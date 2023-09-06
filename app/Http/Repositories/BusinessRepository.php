<?php

namespace App\Http\Repositories;

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessDayTiming;
use App\Models\BusinessFeature;
use App\Models\BusinessGallery;
use App\Models\BusinessLanguage;
use App\Models\BusinessPaymentMethod;
use App\Models\BusinessSocialMedia;
use App\Models\BusinessSubCategory;
use App\Models\BusinessUpgrade;
use App\Models\Package;
use App\Models\User;
use App\Models\Admin;
use Image;
use Str;
use DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminBusinessInformation;
use App\Notifications\UserBusinessInformation;
use Illuminate\Support\Facades\Auth;

class BusinessRepository
{

    public function store(
        $request1 = [],
        $request2 = [],
        $request3 = [],
        $request4 = [],
        $request5 = []
    ) {

        $data = $request1->validated();

        $doc = $request1->file("image");
        if (!empty($doc)) {
            if (explode("/", $doc->getClientMimeType())[0] == "image") {
                $data["image"] = $this->imageUpload($doc, 'business/images/');
            }
        }

        $data["created_by"] = auth()->user()->id;
        $data["updated_by"] = auth()->user()->id;
        $data["user_id"] = $request1->user_id;
        $data["transaction_id"] = Str::random(12) . time();
        if (Business::create($data)) {
            $error = 0;
            $business_id = DB::getPdo()->lastInsertId();

            //business category
            $data = $request2->validated();
            $data["business_id"] = $business_id;

            if (!BusinessCategory::create($data)) {
                $error++;
            }

            //business sub category
            foreach ($request3->sub_category_ids as $subcategory) {
                $data = [
                    "business_id" => $business_id,
                    "sub_category_id" => $subcategory,
                ];

                if (!BusinessSubCategory::create($data)) {
                    $error++;
                }
            }

            //business gallery
            if (!empty($request4->galleries)) {
                foreach ($request4->galleries as $doc) {
                    $data["image"] = $doc;
                    $data["business_id"] = $business_id;
                    if (!BusinessGallery::create($data)) {
                        $error++;
                    }

                }
            }

            //business language
            if (!empty($request4->languages)) {
                foreach ($request4->languages as $language) {
                    $data = [
                        "business_id" => $business_id,
                        "language_id" => $language,
                    ];

                    if (!BusinessLanguage::create($data)) {
                        $error++;
                    }
                }
            }

            //business payment
            if (!empty($request4->payment_methods)) {
                foreach ($request5->payment_methods as $payment_method) {
                    $data = [
                        "business_id" => $business_id,
                        "payment_method_id" => $payment_method,
                    ];

                    if (!BusinessPaymentMethod::create($data)) {
                        $error++;
                    }
                }
            }

            //business social media
            if (!empty($request4->social_names)) {
                foreach ($request5->social_names as $key => $social_name) {
                    $data = [
                        "business_id" => $business_id,
                        "name" => $social_name,
                        "url" => $request5->social_urls[$key],
                    ];

                    if (!BusinessSocialMedia::create($data)) {
                        $error++;
                    }
                }
            }

            //business opening hours
            if (!empty($request4->opening_days)) {
                foreach ($request5->opening_days as $key=>$opening_day) {
                    $data = [
                        "business_id"   => $business_id,
                        "day"           => $opening_day,
                        "time"          => $request4->opening_hour_timing[$key],
                        "from_time"     => date("H:i:s", strtotime($request4->opening_from_timing[$key])),
                        "to_time"       => date("H:i:s", strtotime($request4->opening_to_timing[$key])),
                    ];

                    if (!BusinessDayTiming::create($data)) {
                        $error++;
                    }
                }
            }

            //business upgrade
            $package_price = Package::find($request4->package_id)->price ?? 0;

            $gst_percentage = User::with("province")->find($request4->user_id)->province->tax ?? 0;
            $gst_amount = (session()->get('registration_step1_gst_per') * $package_price) / 100;
            $data = [
                "business_id" => $business_id,
                "package_id" => $request4->package_id,
                "gst_percentage" => $gst_percentage,
                "gst_amount" => $gst_amount,
                "package_price" => $package_price,
                "total_amount" => ($package_price + $gst_amount),
                "upgraded_date"     => date("Y-m-d",strtotime($request4->upgraded_date)),
                "expired_date"      => date("Y-m-d", strtotime(date("Y-m-d", strtotime($request4->upgraded_date)) . " + 1 year")),
                "gst_amount" => $gst_amount,
            ];
            if (!BusinessUpgrade::create($data)) {
                $error++;
            }

            // business other featured
            if (session()->has('registration_step2_optional_featured')) {
                foreach (session()->get('registration_step2_optional_featured') as $feature) {
                    $data = [
                        "business_id" => $business_id,
                        "feature" => $feature,
                    ];

                    if (!BusinessFeature::create($data)) {
                        $error++;
                    }
                }
            }

            if ($error > 0) {
                User::where("id", session()->get('user_id'))->delete();
                Business::where("id", $business_id)->delete();
                BusinessCategory::where("business_id", $business_id)->delete();
                BusinessSubCategory::where("business_id", $business_id)->delete();
                BusinessLanguage::where("business_id", $business_id)->delete();
                BusinessPaymentMethod::where("business_id", $business_id)->delete();
                BusinessUpgrade::where("business_id", $business_id)->delete();
                BusinessFeature::where("business_id", $business_id)->delete();
                BusinessSocialMedia::where("business_id", $business_id)->delete();
                BusinessDayTiming::where("business_id", $business_id)->delete();
                return false;
            }
            return true;
        }
        return false;
    }

    public function update(
        $request1 = [],
        $request2 = [],
        $request3 = [],
        $request4 = [],
        $request5 = [],
        $business = []
    )
    {
        $data = $request1->validated();

        $doc = $request1->file("image");
        if (!empty($doc)) {
            if (explode("/", $doc->getClientMimeType())[0] == "image") {
                $data["image"] = $this->imageUpload($doc, 'business/images/');
            }
        }

        $data["updated_by"] = auth()->user()->id;
        $data["user_id"] = $request1->user_id;
        if ($business->update($data)) {
            //business category
            $data = $request2->validated();
            $data["business_id"] = $business->id;
            BusinessCategory::where("business_id",$business->id)->delete();
            BusinessCategory::create($data);

            //business sub category
            BusinessSubCategory::where("business_id",$business->id)->delete();
            foreach ($request3->sub_category_ids as $subcategory) {
                $data = [
                    "business_id" => $business->id,
                    "sub_category_id" => $subcategory,
                ];

                BusinessSubCategory::create($data);
            }

            //business gallery
            BusinessGallery::where("business_id",$business->id)->delete();
            if (!empty($request4->galleries)) {
                foreach ($request4->galleries as $doc) {
                    $data["image"] = $doc;
                    $data["business_id"] = $business->id;
                    BusinessGallery::create($data);

                }
            }

            //business language
            BusinessLanguage::where("business_id",$business->id)->delete();
            if (!empty($request4->languages)) {
                foreach ($request4->languages as $language) {
                    $data = [
                        "business_id" => $business->id,
                        "language_id" => $language,
                    ];

                    BusinessLanguage::create($data);
                }
            }

            //business payment
            BusinessPaymentMethod::where("business_id",$business->id)->delete();
            if (!empty($request4->payment_methods)) {
                foreach ($request5->payment_methods as $payment_method) {
                    $data = [
                        "business_id" => $business->id,
                        "payment_method_id" => $payment_method,
                    ];

                    BusinessPaymentMethod::create($data);
                }
            }

            //business social media
            BusinessSocialMedia::where("business_id",$business->id)->delete();
            if (!empty($request4->social_names)) {
                foreach ($request5->social_names as $key => $social_name) {
                    $data = [
                        "business_id" => $business->id,
                        "name" => $social_name,
                        "url" => $request5->social_urls[$key],
                    ];

                    BusinessSocialMedia::create($data);
                }
            }

            //business opening hours
            BusinessDayTiming::where("business_id",$business->id)->delete();
            if (!empty($request4->opening_days)) {
                foreach ($request5->opening_days as $key=>$opening_day) {
                    $data = [
                        "business_id"   => $business->id,
                        "day"           => $opening_day,
                        "time"          => $request4->opening_hour_timing[$key],
                        "from_time"     => date("H:i:s", strtotime($request4->opening_from_timing[$key])),
                        "to_time"       => date("H:i:s", strtotime($request4->opening_to_timing[$key])),
                    ];

                    BusinessDayTiming::create($data);
                }
            }

            //business upgrade
            // BusinessUpgrade::where("id",$business->business_upgrade_latest->id)->delete();
            $package_price = Package::find($request4->package_id)->price ?? 0;

            $gst_percentage = User::with("province")->find($request4->user_id)->province->tax ?? 0;
            $gst_amount = (session()->get('registration_step1_gst_per') * $package_price) / 100;

            $data = [
                "business_id"       => $business->id,
                "gst_percentage"    => $gst_percentage,
                "gst_amount"        => $gst_amount,
                "package_price"     => $package_price,
                "total_amount"      => ($package_price + $gst_amount),
                "gst_amount"        => $gst_amount,
            ];

            if(Auth::guard('admin')->check()){
                $data["package_id"] =$request4->package_id;
                $data["upgraded_date"] = date("Y-m-d",strtotime($request4->upgraded_date));
                $data["expired_date"] =date("Y-m-d", strtotime(date("Y-m-d", strtotime($request4->upgraded_date)) . " + 1 year"));
            }

            BusinessUpgrade::where("id",$business->business_upgrade_latest->id)->update($data);

            // business other featured
            if (session()->has('registration_step2_optional_featured')) {
                foreach (session()->get('registration_step2_optional_featured') as $feature) {
                    $data = [
                        "business_id" => $business->id,
                        "feature" => $feature,
                    ];

                    if (!BusinessFeature::create($data)) {
                        $error++;
                    }
                }
            }
        }
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

    public function gallery_upload($request)
    {
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $file_name = $this->imageUpload($image, 'business/galleries/');

            return [
                "code" => 200,
                "status" => "success",
                "file_name" => $file_name,
            ];
        }

        return [
            "code" => 404,
            "status" => "no file",
        ];
    }

    public function business_admin_email_confirmation($result = [])
    {
        $admins = Admin::where("status", 1)->get();
        // $optional_content = "";
        // foreach ($business->business_feature_temps as $key => $feature) {
        //     if ($feature->feature == "1") {
        //         $optional_content .= ($key + 1) . " 300*300 Banner Listing<br/>";
        //     } elseif ($feature->feature == "2") {
        //         $optional_content .= ($key + 1) . " 300*600 Banner Listing<br/>";
        //     } elseif ($feature->feature == "3") {
        //         $optional_content .= ($key + 1) . " Feature Listing<br/>";
        //     }
        // }
        $content = [
            "subject" => "Toronto Connection | Business Registration",
            "content" => "There is a new Business Registration for Toronto Connection. New Business name is
            " . $result->name . ". Please view and verify.<br/><br/>",
        ];
        foreach ($admins as $admin) {
            $content["greeting"] = "Dear " . ucfirst($admin->fname) . " " . ucfirst($admin->lname);
            Notification::send($admin, new AdminBusinessInformation($content));
        }
        return true;
    }

    public function business_user_email_confirmation($request = [])
    {
        $user = User::find($request->user_id);
        $content = [
            "greeting" => "Hi " . ucfirst($user->fname) . " " . ucfirst($user->lname),
            "subject" => "Toronto Connection | Business Registration",
            "content" => "Welcome to Toronto Connection! We are extremely happy that you have decided to advertise
            with us. Toronto Connection is a great way to increase visibility to your business. Please ensure
            that you complete your business profile with as much detail as possible. If you have any
            questions, please reach out to us via email.",
        ];
        $user = User::find($user->id);
        Notification::send($user, new UserBusinessInformation($content));
        return true;
    }

}
