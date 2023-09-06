<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingAppointmentRequest;
use App\Http\Requests\BusinessCategoryRequest;
use App\Http\Requests\BusinessLanguageRequest;
use App\Http\Requests\BusinessPaymentRequest;
use App\Http\Requests\BusinessRequest;
use App\Http\Requests\BusinessSubCategoryRequest;
use App\Http\Requests\BusinessUserRegistrationRequest;
use App\Http\Requests\EnquiryRequest;
use App\Http\Requests\ReviewRequest;
use App\Http\Requests\UserRequest;
use App\Models\Admin;
use App\Models\Advertisement;
use App\Models\Booking;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessCategoryTemp;
use App\Models\BusinessDayTiming;
use App\Models\BusinessDayTimingTemp;
use App\Models\BusinessFeature;
use App\Models\BusinessFeatureTemp;
use App\Models\BusinessGallery;
use App\Models\BusinessLanguage;
use App\Models\BusinessLanguageTemp;
use App\Models\BusinessPaymentMethod;
use App\Models\BusinessPaymentMethodTemp;
use App\Models\BusinessSocialMedia;
use App\Models\BusinessSocialMediaTemp;
use App\Models\BusinessSubCategory;
use App\Models\BusinessSubCategoryTemp;
use App\Models\BusinessTemp;
use App\Models\BusinessUpgrade;
use App\Models\BusinessUpgradeTemp;
use App\Models\BusinessUser;
use App\Models\Category;
use App\Models\Country;
use App\Models\DefaultLogo;
use App\Models\Enquiry;
use App\Models\HeaderBanner;
use App\Models\Language;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\Province;
use App\Models\Review;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserTemp;
use App\Models\Wishlist;
use App\Notifications\AdminBusinessInformation;
use App\Notifications\AdminContactFormInformation;
use App\Notifications\AdminReviewConfirmation;
use App\Notifications\AdminUserRegistrationNotification;
use App\Notifications\UserBookingNotification;
use App\Notifications\UserBusinessInformation;
use App\Notifications\UserContactFormInformation;
use App\Notifications\UserRegistrationNotification;
use App\Notifications\UserReviewConfirmation;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Image;
use Str;

class HomeController extends Controller
{
    public function index()
    {
        $default_logo = DefaultLogo::where("status", 1)->latest()->first();
        $businesses = Business::with("avgReview")->withCount('reviews')->withCount('wishLists')->where("is_feature", 1)->where("status", 1)->get();
        $banners = HeaderBanner::where("status", 1)->get();
        $categories = $this->search_categories();
        return view("Frontend.Home.index", compact('default_logo', 'businesses', 'banners', 'categories'));
    }

    public function registration_step1()
    {
        session()->forget('registration_step1');
        session()->forget('registration_step2');
        session()->forget('registration_step3');
        session()->forget('registration_step4');
        session()->forget('registration_ref_no');
        session()->forget('registration_step2_optional_featured');
        session()->forget('registration_step1_gst_per');

        $countries = Country::where('status', 1)->orderBy('name', 'asc')->get();
        return view("Frontend.Registration.index", compact('countries'));
    }

    public function registration_step2()
    {
        $package = Package::where('status', 1)->orderBy('id', 'asc')->first();
        return view("Frontend.Registration.index", compact('package'));
    }

    public function registration_step3()
    {
        $categories = Category::orderBy("name", "asc")->where("status", 1)->get();
        $languages = Language::orderBy("name", "asc")->where("status", 1)->get();
        $countries = Country::orderBy("name", "asc")->where("status", 1)->get();
        $paymentMethods = PaymentMethod::orderBy("name", "asc")->where("status", 1)->get();
        return view("Frontend.Registration.index", compact('categories', 'languages', 'countries', 'paymentMethods'));
    }

    public function registration_step4()
    {
        $detail = BusinessTemp::with("business_upgrade_temps")->find(session()->get('business_temp_id'));
        return view("Frontend.Registration.index", compact('detail'));
    }

    public function registration_submit_step1(UserRequest $request)
    {
        $data = $request->validated();
        $province_gst = Province::find($request->province_id)->tax ?? 0;

        $data["password"] = Hash::make($request->password);
        UserTemp::create($data);
        $user_temp_id = DB::getPdo()->lastInsertId();

        session()->put('user_temp_id', $user_temp_id);
        session()->put('registration_step1', $data);
        session()->put('registration_step1_gst_per', $province_gst);

        // dd($data);

        return redirect(route('registration.step2'));
    }

    public function registration_submit_step2(Request $request)
    {
        $request->validate([
            'package_id' => 'required',
        ]);
        session()->put('package_id', $request->package_id);
        session()->put('registration_step2', true);
        session()->put('registration_step2_optional_featured', $request->optional_featured);
        return redirect(route('registration.step3'));
    }

    public function registration_submit_step3(
        BusinessRequest $request1,
        BusinessCategoryRequest $request2,
        BusinessSubCategoryRequest $request3,
        BusinessLanguageRequest $request4,
        BusinessPaymentRequest $request5
    ) {
        $data = $request1->validated();
        $doc = $request1->file("image");
        if (!empty($doc)) {
            if (explode("/", $doc->getClientMimeType())[0] == "image") {
                $data["image"] = $this->imageUpload($doc, 'business/images/');
            } else {
                $data["image"] = $this->documentUpload($doc, 'business/images/');
            }
        }

        $data["user_temp_id"] = session()->get('user_temp_id');
        $data["transaction_id"] = Str::random(12) . time();

        if (BusinessTemp::create($data)) {
            $error = 0;
            $business_temp_id = DB::getPdo()->lastInsertId();

            //business category
            $data = $request2->validated();
            $data["business_temp_id"] = $business_temp_id;

            if (!BusinessCategoryTemp::create($data)) {
                $error++;
            }

            //business sub category
            foreach ($request3->sub_category_ids as $subcategory) {
                $data = [
                    "business_temp_id" => $business_temp_id,
                    "sub_category_id" => $subcategory,
                ];

                if (!BusinessSubCategoryTemp::create($data)) {
                    $error++;
                }
            }

            //business language
            if (!empty($request4->languages)) {
                foreach ($request4->languages as $language) {
                    $data = [
                        "business_temp_id" => $business_temp_id,
                        "language_id" => $language,
                    ];

                    if (!BusinessLanguageTemp::create($data)) {
                        $error++;
                    }
                }
            }

            //business payment
            if (!empty($request4->payment_methods)) {
                foreach ($request5->payment_methods as $payment_method) {
                    $data = [
                        "business_temp_id" => $business_temp_id,
                        "payment_method_id" => $payment_method,
                    ];

                    if (!BusinessPaymentMethodTemp::create($data)) {
                        $error++;
                    }
                }
            }

            //business social media
            if (!empty($request4->social_names)) {
                foreach ($request5->social_names as $key => $social_name) {
                    $data = [
                        "business_temp_id" => $business_temp_id,
                        "name" => $social_name,
                        "url" => $request5->social_urls[$key],
                    ];

                    if (!BusinessSocialMediaTemp::create($data)) {
                        $error++;
                    }
                }
            }

            //business opening hours
            if (!empty($request4->opening_days)) {
                foreach ($request5->opening_days as $key => $opening_day) {
                    $data = [
                        "business_temp_id" => $business_temp_id,
                        "day" => $opening_day,
                        "time" => $request4->opening_hour_timing[$key],
                        "from_time" => date("H:i:s", strtotime($request4->opening_from_timing[$key])),
                        "to_time" => date("H:i:s", strtotime($request4->opening_to_timing[$key])),
                    ];

                    if (!BusinessDayTimingTemp::create($data)) {
                        $error++;
                    }
                }
            }

            //business upgrade
            $package_price = Package::find(session()->get('package_id'))->price ?? 0;
            $gst_amount = (session()->get('registration_step1_gst_per') * $package_price) / 100;
            $data = [
                "business_temp_id" => $business_temp_id,
                "package_id" => session()->get('package_id'),
                "gst_percentage" => session()->get('registration_step1_gst_per'),
                "gst_amount" => $gst_amount,
                "package_price" => $package_price,
                "total_amount" => ($package_price + $gst_amount),
                "upgraded_date" => date("Y-m-d"),
                "expired_date" => date('Y-m-d', strtotime('+1 year')),
                "gst_amount" => $gst_amount,
            ];
            if (!BusinessUpgradeTemp::create($data)) {
                $error++;
            }

            // business other featured
            if (session()->has('registration_step2_optional_featured')) {
                foreach (session()->get('registration_step2_optional_featured') as $feature) {
                    $data = [
                        "business_temp_id" => $business_temp_id,
                        "feature" => $feature,
                    ];

                    if (!BusinessFeatureTemp::create($data)) {
                        $error++;
                    }
                }
            }

            if ($error > 0) {
                UserTemp::where("id", session()->get('user_temp_id'))->delete();
                BusinessTemp::where("id", $business_temp_id)->delete();
                BusinessCategoryTemp::where("business_temp_id", $business_temp_id)->delete();
                BusinessSubCategoryTemp::where("business_temp_id", $business_temp_id)->delete();
                BusinessLanguageTemp::where("business_temp_id", $business_temp_id)->delete();
                BusinessPaymentMethodTemp::where("business_temp_id", $business_temp_id)->delete();
                BusinessUpgradeTemp::where("business_temp_id", $business_temp_id)->delete();
                BusinessFeatureTemp::where("business_temp_id", $business_temp_id)->delete();
                BusinessSocialMediaTemp::where("business_temp_id", $business_temp_id)->delete();
                BusinessDayTimingTemp::where("business_temp_id", $business_temp_id)->delete();
                return redirect(route('registration.step1'));
            }
        }

        session()->put('business_temp_id', $business_temp_id);
        session()->put('registration_step3', true);
        return redirect(route('registration.step4'));
    }

    public function registration_submit_step4(Request $request)
    {
        $business = BusinessTemp::where("id", session()->get('business_temp_id'))
            ->with(
                "business_category_temps",
                "business_day_timing_temps",
                "business_feature_temps",
                "business_gallery_temps",
                "business_language_temps",
                "business_payment_method_temps",
                "business_social_media_temps",
                "business_sub_category_temps",
                "business_upgrade_temps",
                "user_temps"
            )
            ->first();

        $user_id = $this->user_temps($business->user_temps);
        $business_id = $this->business_temps($business, $user_id);

        $result1 = $this->business_category_temps($business->business_category_temps, $business_id);
        $result2 = $this->business_day_timing_temps($business->business_day_timing_temps, $business_id);
        $result3 = $this->business_feature_temps($business->business_feature_temps, $business_id);
        $result4 = $this->business_gallery_temps($business->business_gallery_temps, $business_id);
        $result5 = $this->business_language_temps($business->business_language_temps, $business_id);
        $result6 = $this->business_payment_method_temps($business->business_payment_method_temps, $business_id);
        $result7 = $this->business_social_media_temps($business->business_social_media_temps, $business_id);
        $result8 = $this->business_sub_category_temps($business->business_sub_category_temps, $business_id);
        $result9 = $this->business_upgrade_temps($business->business_upgrade_temps, $business_id);

        $this->business_admin_email_confirmation($business);
        $this->business_user_email_confirmation($business);

        session()->flash('pop-up-success', 'Your business has been registered successfully!');
        session()->flash('pop-up-success-title', 'Registration-Toronto Connections');

        return redirect(route('home.index'));
    }

    //Image Upload
    public function imageUpload($image, $folder)
    {
        $path = [];
        $x = 10;
        if (isset($image) && !empty($image)) {
            $imageName = Str::random(10) . time() . '.' . $image->extension();
            $path = $folder . $imageName;
            if (!is_dir(storage_path('app/public/' . $folder))) {
                mkdir(storage_path('app/public/' . $folder), 0777, true);
            }
            $img = Image::make($image->getRealPath());
            $img->save(storage_path('app/public/' . $path), $x);
        }
        return $path;
    }

    // document upload
    public function documentUpload($document, $folder)
    {
        $path = [];
        if (isset($document)) {
            $documentName = Str::random($length = 10) . time() . '.' . $document->extension();
            $path = $folder . $documentName;
            if (!is_dir(storage_path('app/public/' . $folder))) {
                mkdir(storage_path('app/public/' . $folder), 0777, true);
            }

            $document->move(storage_path('app/public/' . $folder), $documentName);
        }
        return $path;
    }

    public function user_temps($user_temps = [])
    {
        if (!empty($user_temps)) {
            $user = new User();
            $user->fname = $user_temps->fname;
            $user->lname = $user_temps->lname;
            $user->email = $user_temps->email;
            $user->phone = $user_temps->phone;
            $user->password = $user_temps->password;
            $user->address = $user_temps->address;
            $user->lat = $user_temps->lat;
            $user->lng = $user_temps->lng;
            $user->postcode = $user_temps->postcode;
            $user->country_id = $user_temps->country_id;
            $user->province_id = $user_temps->province_id;
            $user->city_id = $user_temps->city_id;
            $user->status = $user_temps->status;
            $user->created_by = $user_temps->created_by;
            $user->updated_by = $user_temps->updated_by;
            return ($user->save()) ? $user->id : false;
        }
    }

    public function business_temps($business_temps = [], $user_id = null)
    {
        if (!empty($business_temps)) {
            $business                       = new Business();
            $business->name                 = $business_temps->name;
            $business->transaction_id       = $business_temps->transaction_id;
            $business->email                = $business_temps->email;
            $business->phone                = $business_temps->phone;
            $business->user_id              = $user_id;
            $business->country_id           = $business_temps->country_id;
            $business->province_id          = $business_temps->province_id;
            $business->city_id              = $business_temps->city_id;
            $business->description          = $business_temps->description;
            $business->postcode             = $business_temps->postcode;
            $business->address              = $business_temps->address;
            $business->lat                  = $business_temps->lat;
            $business->lng                  = $business_temps->lng;
            $business->website              = $business_temps->website;
            $business->image                = $business_temps->image;
            $business->video                = $business_temps->video;
            $business->is_feature           = $business_temps->is_feature;
            $business->area_of_practice     = $business_temps->area_of_practice;
            $business->product_and_service  = $business_temps->product_and_service;
            $business->specialization       = $business_temps->specialization;
            $business->priority             = $business_temps->priority;
            $business->online_order         = $business_temps->online_order;
            $business->online_order_link    = $business_temps->online_order_link;
            $business->status               = $business_temps->status;
            $business->created_by           = $business_temps->created_by;
            $business->updated_by           = $business_temps->updated_by;

            return ($business->save()) ? $business->id : false;
        }
    }

    public function business_category_temps($business_category_temps = [], $business_id = null)
    {
        if (!empty($business_category_temps)) {
            $business_category = new BusinessCategory();
            $business_category->business_id = $business_id;
            $business_category->category_id = $business_category_temps->category_id;
            return ($business_category->save()) ? true : false;
        }
    }

    public function business_day_timing_temps($business_day_timing_temps = [], $business_id = null)
    {
        if (!empty($business_day_timing_temps)) {
            $error = 0;
            foreach ($business_day_timing_temps as $business_day_timing_temp) {
                $business_day_timing = new BusinessDayTiming();
                $business_day_timing->business_id = $business_id;
                $business_day_timing->day = $business_day_timing_temp->day;
                $business_day_timing->time = $business_day_timing_temp->time;
                $business_day_timing->from_time = $business_day_timing_temp->from_time;
                $business_day_timing->to_time = $business_day_timing_temp->to_time;
                $error += ($business_day_timing->save()) ? 0 : 1;
            }
            return ($error <= 0) ? true : false;
        }
    }

    public function business_feature_temps($business_feature_temps = [], $business_id = null)
    {
        if (!empty($business_feature_temps)) {
            $error = 0;
            foreach ($business_feature_temps as $business_feature_temp) {
                $business_feature = new BusinessFeature();
                $business_feature->business_id = $business_id;
                $business_feature->feature = $business_feature_temp->feature;
                $error += ($business_feature->save()) ? 0 : 1;
            }
            return ($error <= 0) ? true : false;
        }
    }

    public function business_gallery_temps($business_gallery_temps = [], $business_id = null)
    {
        if (!empty($business_gallery_temps)) {
            $error = 0;
            foreach ($business_gallery_temps as $business_gallery_temp) {
                $business_gallery = new BusinessGallery();
                $business_gallery->business_id = $business_id;
                $business_gallery->image = $business_gallery_temp->image;
                $error += ($business_gallery->save()) ? 0 : 1;
            }
            return ($error <= 0) ? true : false;
        }
    }

    public function business_language_temps($business_language_temps = [], $business_id = null)
    {
        if (!empty($business_language_temps)) {
            $error = 0;
            foreach ($business_language_temps as $business_language_temp) {
                $business_language = new BusinessLanguage();
                $business_language->business_id = $business_id;
                $business_language->language_id = $business_language_temp->language_id;
                $error += ($business_language->save()) ? 0 : 1;
            }
            return ($error <= 0) ? true : false;
        }
    }

    public function business_payment_method_temps($business_payment_method_temps = [], $business_id = null)
    {
        if (!empty($business_payment_method_temps)) {
            $error = 0;
            foreach ($business_payment_method_temps as $business_payment_method_temp) {
                $business_payment_method = new BusinessPaymentMethod();
                $business_payment_method->business_id = $business_id;
                $business_payment_method->payment_method_id = $business_payment_method_temp->payment_method_id;
                $error += ($business_payment_method->save()) ? 0 : 1;
            }
            return ($error <= 0) ? true : false;
        }
    }

    public function business_social_media_temps($business_social_media_temps = [], $business_id = null)
    {
        if (!empty($business_social_media_temps)) {
            $error = 0;
            foreach ($business_social_media_temps as $business_social_media_temp) {
                $business_social_media = new BusinessSocialMedia();
                $business_social_media->business_id = $business_id;
                $business_social_media->name = $business_social_media_temp->name;
                $business_social_media->url = $business_social_media_temp->url;
                $error += ($business_social_media->save()) ? 0 : 1;
            }
            return ($error <= 0) ? true : false;
        }
    }


    public function business_sub_category_temps($business_sub_category_temps = [], $business_id = null)
    {
        if (!empty($business_sub_category_temps)) {
            $error = 0;
            foreach ($business_sub_category_temps as $business_sub_category_temp) {
                $business_sub_category = new BusinessSubCategory();
                $business_sub_category->business_id = $business_id;
                $business_sub_category->sub_category_id = $business_sub_category_temp->sub_category_id;
                $error += ($business_sub_category->save()) ? 0 : 1;
            }
            return ($error <= 0) ? true : false;
        }
    }

    public function business_upgrade_temps($business_upgrade_temps = [], $business_id = null)
    {
        if (!empty($business_upgrade_temps)) {
            // $error = 0;
            // foreach($business_upgrade_temps as $business_upgrade_temp){
            $business_upgrade = new BusinessUpgrade();
            $business_upgrade->business_id = $business_id;
            $business_upgrade->package_id = $business_upgrade_temps->package_id;
            $business_upgrade->gst_percentage = $business_upgrade_temps->gst_percentage;
            $business_upgrade->gst_amount = $business_upgrade_temps->gst_amount;
            $business_upgrade->total_amount = $business_upgrade_temps->total_amount;
            $business_upgrade->package_price = $business_upgrade_temps->package_price;
            $business_upgrade->upgraded_date = $this->db_date_format($business_upgrade_temps->upgraded_date);
            $business_upgrade->expired_date = $this->c($business_upgrade_temps->expired_date);
            $business_upgrade->status = $business_upgrade_temps->status;
            $business_upgrade->created_by = $business_upgrade_temps->updated_by;
            // $error += ($business_upgrade->save())?0:1;
            // }
            return ($business_upgrade->save()) ? true : false;
        }
    }

    public function business_admin_email_confirmation($business = [])
    {
        $admins = Admin::where("status", 1)->get();
        $optional_content = "";
        foreach ($business->business_feature_temps as $key => $feature) {
            if ($feature->feature == "1") {
                $optional_content .= ($key + 1) . " 300*300 Banner Listing<br/>";
            } elseif ($feature->feature == "2") {
                $optional_content .= ($key + 1) . " 300*600 Banner Listing<br/>";
            } elseif ($feature->feature == "3") {
                $optional_content .= ($key + 1) . " Feature Listing<br/>";
            }
        }

        $admins = Admin::where('status', 1)->get();
        $optional_content = "";
        foreach ($business->business_feature_temps as $key => $feature) {
            if ($feature->feature == '1') {
                $optional_content .= ($key + 1) . " 300*300 banner listing<br/>";
            } elseif ($feature->feature == "2") {
                $optional_content .= ($key + 1) . "300 * 600 banner listing<br/>";
            } elseif ($feature->feature == "3") {
                $optional_content .= ($key + 1) . "Feature Listing<br/>";
            }
        }
        
        $content = [
            "subject" => "Toronto Connection | Business Registration",
            "content" => "There is a new Business Registration for Toronto Connection. New Business name is
            " . $business->name . ". Please view and verify.<br/><br/>" . $optional_content,
        ];
        foreach ($admins as $admin) {
            $content["greeting"] = "Dear " . ucfirst($admin->fname) . " " . ucfirst($admin->lname);
            Notification::send($admin, new AdminBusinessInformation($content));
        }
        return true;
    }

    public function business_user_email_confirmation($business = [])
    {
        $content = [
            "greeting" => "Hi " . ucfirst($business->user_temps->fname) . " " . ucfirst($business->user_temps->lname),
            "subject" => "Toronto Connection | Business Registration",
            "content" => "Welcome to Toronto Connection! We are extremely happy that you have decided to advertise
            with us. Toronto Connection is a great way to increase visibility to your business. Please ensure
            that you complete your business profile with as much detail as possible. If you have any
            questions, please reach out to us via email.",
        ];
        $user = User::find($business->user_id);
        Notification::send($user, new UserBusinessInformation($content));
        return true;
    }

    public function db_date_format($date = null)
    {
        return (!empty($date)) ? date("Y-m-d", strtotime($date)) : "";
    }

    public function listing_page(Request $request)
    {
        $search_category = $request->search_category;
        $search_city = $request->search_city;
        $relevance = $request->relevance ?? "Relevance";
        $searchType = $request->searchType;

        $categoryServiceSearchArray = $request->searchCategoryService ?? [];
        $languageSearchArray = $request->searchLanguage ?? [];

        $businesses = Business::with(
            "category.category",
            "subCategories.subCategory",
            "city",
            "province",
            "business_upgrade_latest",
            "languages",
            "avgReview",
            "reviews",
            "business_day_timings"
        )
            ->withCount('reviews');

        //Home category and subcategory search
        if ($search_category) {
            $subCategoriesIds = SubCategory::select('category_id')->where("status", 1)->where('name', 'like', '%' . $search_category . '%')->get();
            $businesses->whereHas("category.category", function ($query) use ($subCategoriesIds, $search_category) {
                $query->where('name', 'like', '%' . $search_category . '%');
                if (!$subCategoriesIds->isEmpty()) {
                    foreach ($subCategoriesIds as $subCategory) {
                        $query->orWhere('id', $subCategory->category_id);
                    }
                }
            });
        }

        //Home city search
        if ($search_city) {
            $businesses->where(function ($query) use ($search_city) {
                $query->whereHas("city", function ($query1) use ($search_city) {
                    $query1->where('name', 'like', '%' . $search_city . '%');
                });
                $query->orWhereHas("province", function ($query2) use ($search_city) {
                    $query2->where('name', 'like', '%' . $search_city . '%');
                });
            });
        }

        //listing page language search
        if ($searchType == "category service search") {

            if (!empty($categoryServiceSearchArray)) {
                $businesses->whereHas("subCategories", function ($query) use ($categoryServiceSearchArray) {
                    foreach ($categoryServiceSearchArray as $key => $sub_category) {
                        if ($key == 0) {
                            $query->where('sub_category_id', $sub_category);
                        } else {
                            $query->orWhere('sub_category_id', $sub_category);
                        }
                    }
                });
            }
        } elseif ($searchType == "language search") {
            if (!empty($languageSearchArray)) {
                $businesses->whereHas("languages", function ($query) use ($languageSearchArray) {
                    foreach ($languageSearchArray as $key => $language) {
                        if ($key == 0) {
                            $query->where('language_id', $language);
                        } else {
                            $query->orWhere('language_id', $language);
                        }
                    }
                });
            }
        } elseif ($relevance == "highest rated" || $searchType == "most popular") {
            $businesses->withCount(['reviews as average_rating' => function ($query) {
                $query->select(DB::raw('coalesce(avg(score),0)'));
            }])->orderBy('average_rating', 'DESC');
        } elseif ($relevance == "most reviewed") {
            $businesses->orderBy('reviews_count', 'DESC');
        } elseif ($relevance == "alphabetical") {
            $businesses->orderBy('name', 'ASC');
        } elseif ($relevance == "nearest") {

            if (isset($_COOKIE['geolocation']) && !empty($_COOKIE['geolocation'])) {
                $geolocation = explode("|", $_COOKIE['geolocation']);

                $businesses->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $geolocation[0] . "))
                    * cos(radians(lat))
                    * cos(radians(lng) - radians(" . $geolocation[1] . "))
                    + sin(radians(" . $geolocation[0] . "))
                    * sin(radians(lat))) AS distance")
                )
                    ->orderBy('distance', 'asc');
            }
        } elseif ($searchType == "open now") {
            $businesses->whereHas("business_day_timings", function ($query) {
                $query
                    ->where("from_time", "<=", date("H:i"))
                    ->where("to_time", ">=", date("H:i"))
                    ->where("day", date("l"));
            });
        }

        //ordered by premium then free package
        $businesses->with(['business_upgrade_latest' => function ($query) {
            $query->orderByRaw("FIELD(package_id , '1', '2','') ASC")->orderByRaw("RAND()");
        }]);
        $businesses = $businesses
            // ->orderByRaw("FIELD(pack_name , 'Premium Pack', 'Advanced Pack', 'Free Pack','') ASC")
            ->orderBy(BusinessUpgrade::select('package_id')->whereColumn('businesses.id', 'business_upgrades.business_id'), 'asc')
            ->orderByRaw("RAND()")->where('status', 1)->paginate(10);

        //fields fetching
        $default_logo = DefaultLogo::where("status", 1)->latest()->first();

        $advertisement300s = $this->advertisements($search_category, $search_city, 0);

        $advertisement600s = $this->advertisements($search_category, $search_city, 1);

        $categories = $this->search_categories();

        $subCategories = SubCategory::where("status", 1)->with("category");
        if ($search_category) {
            $subCategories->where('name', 'like', '%' . $search_category . '%')
                ->orWhereHas("category", function ($query) use ($search_category) {
                    $query->where('name', 'like', '%' . $search_category . '%');
                });
        }
        $subCategories = $subCategories->get();

        $languages = Language::where("status", 1)->get();

        return view("Frontend.Listing.index", compact(
            'default_logo',
            'businesses',
            'advertisement300s',
            'advertisement600s',
            'categories',
            'search_category',
            'search_city',
            'subCategories',
            'relevance',
            'searchType',
            'categoryServiceSearchArray',
            'languageSearchArray',
            'languages'
        ));
    }

    public function advertisements($search_category = null, $search_city = null, $file_status = 3)
    {

        $advertisements = Advertisement::with("categories.category", "cities.city");

        if ($search_category || $search_city) {
            $advertisements->where(function ($query) use ($search_category, $search_city) {
                if ($search_category) {
                    $subCategoriesIds = SubCategory::select('category_id')->where("status", 1)->where('name', 'like', '%' . $search_category . '%')->get();

                    $query->whereHas("categories.category", function ($query1) use ($subCategoriesIds, $search_category) {
                        $query1->where('name', 'like', '%' . $search_category . '%');
                        if (!$subCategoriesIds->isEmpty()) {
                            foreach ($subCategoriesIds as $key => $subCategory) {
                                $query1->orWhere('id', $subCategory->category_id);
                            }
                        }
                    });
                }
                if ($search_city) {
                    if ($search_category) {
                        $query->orWhereHas("cities.city", function ($query2) use ($search_city) {
                            $query2->where('name', 'like', '%' . $search_city . '%');
                        });
                    } else {
                        $query->whereHas("cities.city", function ($query2) use ($search_city) {
                            $query2->where('name', 'like', '%' . $search_city . '%');
                        });
                    }
                }
            });
        }

        $advertisements = $advertisements->where('expired_date', '>=', date("Y-m-d"))
            ->where('status', 1)
            ->where('file_status', $file_status)
            ->inRandomOrder()
            ->limit(1)
            ->get();

        return $advertisements;
    }

    public function detail_page(Business $business)
    {

        //fields fetching
        $default_logo = DefaultLogo::where("status", 1)->latest()->first();

        $advertisement300s = $this->advertisements($business->category->category->name, $business->city->name, 0);

        $advertisement600s = $this->advertisements($business->category->category->name, $business->city->name, 1);

        $categories = $this->search_categories();

        $reviews = Review::where("status", 1)->where("business_id", $business->id)->get();

        return view("Frontend.Detail.index", compact(
            'default_logo',
            'business',
            'advertisement300s',
            'advertisement600s',
            'categories',
            'reviews',
        ));
    }

    public function business_add_favourite(Request $request)
    {
        if (Auth::guard('business_user')->check()) {
            $data = [
                'business_id' => $request->business_id,
                'business_user_id' => Auth::guard('business_user')->user()->id,
            ];
            $exist_check = Wishlist::where('business_id', $data['business_id'])
                ->where('business_user_id', $data['business_user_id'])->first();
            if (!empty($exist_check)) {
                echo "already-added";
                exit;
            }
            if (Wishlist::create($data)) {
                echo "success";
                exit;
            }
        } else {
            echo "not-user";
            exit;
        }
    }

    public function booking_appointment(BookingAppointmentRequest $request)
    {
        $data = $request->validated();
        $data['date'] = date("Y-m-d", strtotime($request->date));
        if (Booking::create($data)) {

            $business = Business::find($request->business_id);

            $admins = Admin::where("status", 1)->get();
            $content = [
                "subject" => $business->name . " | Booking Appointment",
                "content" => "You received the booking appointment from website<br/><br/>
                                    Name : " . $request->name . "<br/>
                                    Email : " . $request->email . "<br/>
                                    Phone : " . $request->phone . "<br/>
                                    Message : " . $request->message . "<br/>
                                    Business : " . $business->name . "<br/>",
            ];



            foreach ($admins as $admin) {
                $content["greeting"] = "Dear " . ucfirst($admin->fname) . " " . ucfirst($admin->lname);
                Notification::send($admin, new AdminReviewConfirmation($content));
            }

            Notification::route("mail", $business->email)->notify(new UserBookingNotification($content));

            $content = [
                'greeting' => 'Hi ' . $request->name,
                'content' => '
                                    Your appointment with ' . $business->name . ' has been booked for ' . date("d-m-Y", strtotime($request->date)) . '. Someone from ' . $business->name . ' will be in touch with you for confirmation and other details. If you don’t hear from them, please contact them directly.
                                    ',
                'subject' => $business->name . ' | Confirmation for Booking an appointment',
            ];

            Notification::route("mail", $request->email)->notify(new UserBookingNotification($content));

            session()->flash('pop-up-success', 'Message has been sent to book an your appointment');
            session()->flash('pop-up-success-title', 'Book an Appointment - Toronto Connections');
            return back();
        }

        session()->flash('pop-up-success', 'Something went wrong try again');
        session()->flash('pop-up-success-title', 'Ratings & Reviews-Toronto Connections');

        return back();
    }

    public function business_review(ReviewRequest $request)
    {
        $data = $request->validated();
        $doc = $request->file("image");
        if (!empty($doc)) {
            if (explode("/", $doc->getClientMimeType())[0] == "image") {
                $data["image"] = $this->imageUpload($doc, 'review/');
            } else {
                $data["image"] = $this->documentUpload($doc, 'review/');
            }
        }
        $ref_no = Str::random(25);
        $data["ref_no"] = $ref_no;
        if (Review::create($data)) {

            $content = [
                "ref_no" => $ref_no,
            ];
            Notification::route("mail", $request->email)->notify(new UserReviewConfirmation($content));

            session()->flash('pop-up-success', 'Confirmation mail sent to your email address.');
            session()->flash('pop-up-success-title', 'Ratings & Reviews-Toronto Connections');
            return back();
        }

        session()->flash('pop-up-success', 'Something went wrong try again');
        session()->flash('pop-up-success-title', 'Ratings & Reviews-Toronto Connections');

        return back();
    }

    public function review_confirmation(Request $request)
    {
        $ref_no = $request->ref_no;
        if ($ref_no) {
            $review = Review::where("ref_no", $ref_no)->where("status", 0)->first();
            if (!empty($review)) {
                $review->status = 1;
                if ($review->update()) {

                    $admins = Admin::where("status", 1)->get();
                    $content = [
                        "subject" => $review->business->name . " | Review from website",
                        "content" => "You received the review from website<br/><br/>
                                            Business : " . $review->business->name . "<br/>
                                            Rate : " . $review->score . "<br/>
                                            Comment : " . (!empty($review->comment) ? $review->comment : "No Comment"),
                    ];

                    foreach ($admins as $admin) {
                        $content["greeting"] = "Dear " . ucfirst($admin->fname) . " " . ucfirst($admin->lname);
                        Notification::send($admin, new AdminReviewConfirmation($content));
                    }

                    session()->flash('pop-up-success', 'Your reviews has been submitted successfully.');
                    session()->flash('pop-up-success-title', 'Ratings & Reviews-Toronto Connections');
                    return redirect(route('home.index'));
                }
            }
        }
        session()->flash('pop-up-success', 'Something went wrong try again');
        session()->flash('pop-up-success-title', 'Ratings & Reviews-Toronto Connections');
        return redirect(route('home.index'));
    }

    public function advertise_with_us()
    {
        $package = Package::where('status', 1)->orderBy('id', 'asc')->first();
        $categories = $this->search_categories();
        return view("Frontend.advertise-with-us", compact('package', 'categories'));
    }

    public function business_review_terms_and_condition()
    {
        $categories = $this->search_categories();
        return view("Frontend.review-terms", compact('categories'));
    }

    public function contact_us()
    {
        $categories = $this->search_categories();
        return view("Frontend.contact-us", compact('categories'));
    }

    public function contact_submit(EnquiryRequest $request)
    {
        Enquiry::create($request->validated());
        $this->enquiry_admin_email_confirmation($request);
        $this->enquiry_user_email_confirmation($request);
        return redirect(route('contact.us'))->with('pop-up-success', 'Your enquiry has been sent successfully');
    }

    public function enquiry_admin_email_confirmation($request = [])
    {
        $admins = Admin::where("status", 1)->get();
        $content = [
            "subject" => "Toronto Connection | Enquiry form contact us page",
            "content" => "You received enquiry form contact us page<br/><br/>Name : " . $request->fname . " " . $request->lname . "<br/>Email : " . $request->email . "<br/>Phone : " . $request->phone . "<br/>Message : " . $request->message . "<br/>",
        ];
        foreach ($admins as $admin) {
            $content["greeting"] = "Dear " . ucfirst($admin->fname) . " " . ucfirst($admin->lname);
            Notification::send($admin, new AdminContactFormInformation($content));
        }
        return true;
    }

    public function enquiry_user_email_confirmation($request = [])
    {
        $content = [
            "greeting" => "Hi " . ucfirst($request->fname) . " " . ucfirst($request->lname),
            "subject" => "Toronto Connection | Thank you for connecting with us",
            "content" => "Thank you for your inquiry. One of our team members will respond shortly to your query. Please do not reply to this email.",
        ];
        Notification::route("mail", $request->email)->notify(new UserContactFormInformation($content));
        return true;
    }

    public function review_email_unique(Request $request)
    {
        $review = Review::where("email", $request->email)->where("business_id", $request->business_id)->first();

        if (!empty($review)) {
            echo "exist";
            exit;
        }
        echo "not-exist";
        exit;
    }

    //business user registration
    public function business_user_registration(BusinessUserRegistrationRequest $request)
    {
        $data = $request->validated();
        $data["password"] = Hash::make($request->password);
        $data["show_password"] = $request->password;

        $last_row = BusinessUser::latest()->first();
        $ref_id = 1001;
        if (!empty($last_row)) {
            $ref_id = $last_row->ref_id + 1;
        }
        $data["ref_id"] = $ref_id;
        if (BusinessUser::create($data)) {

            $admins = Admin::where("status", 1)->get();

            $content = [
                'content' => 'There is a new user registration for Toronto Connection. The new registrant is
                                    ' . ucfirst($request->fname) . ' ' . $request->lname . '. Please view and verify.',
                'subject' => 'Toronto Connection | User Registration',
            ];

            foreach ($admins as $admin) :
                $content["greeting"] = "Dear " . ucfirst($admin->fname) . " " . ucfirst($admin->lname);
                Notification::send($admin, new AdminUserRegistrationNotification($content));
            endforeach;

            $content = [
                'greeting' => 'Hi ' . ucfirst($request->fname) . ' ' . $request->lname,
                'content' => 'Thank you for your registration with Toronto Connection. We hope that you will enjoy browsing
                                    through our website to find what you are looking for. You may unsubscribe from the email list
                                    at any time.',
                'subject' => 'Toronto Connection | User Registration',
            ];
            Notification::route("mail", $request->email)->notify(new UserRegistrationNotification($content));

            session()->flash('pop-up-success', 'Your registration has been done successfully!');
            session()->flash('pop-up-success-title', 'Registration-Toronto Connections');
            return back();
        }
        session()->flash('pop-up-success', 'Something went wrong try again');
        session()->flash('pop-up-success-title', 'Ratings & Reviews-Toronto Connections');
        return back();
    }

    public function browse_by_category()
    {
        $categories = $this->search_categories();
        $categories1 = Category::where("status", 1)->with("subCategories")->orderBy("name", "asc")->get();
        return view("Frontend.Footer.browse-by-category", compact('categories', 'categories1'));
    }

    public function browse_by_location()
    {
        $categories = $this->search_categories();
        $provinces = Province::where("status", 1)->with("cities")->orderBy("name", "asc")->get();
        return view("Frontend.Footer.browse-by-location", compact('categories', 'provinces'));
    }

    public function search_categories()
    {
        return Category::where("status", 1)->where("priority", "!=", "")->orderBy("priority", "asc")->get();
    }

    public function email_test()
    {
        $content = [
            "subject" => "Test Subject",
            "greeting" => "Hi Iyappan",
            "content" => "Welcome to Toronto Connection! We are extremely happy that you have decided to advertise
            with us. Toronto Connection is a great way to increase visibility to your business. Please ensure
            that you complete your business profile <br/> with as much detail as possible. If you have any
            questions, please reach out to us via email.",
        ];

        $admin = Admin::where("status", 1)->first();
        Notification::send($admin, new AdminBusinessInformation($content));
        return "yes";
    }
}
