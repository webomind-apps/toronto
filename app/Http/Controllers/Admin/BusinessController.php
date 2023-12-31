<?php

namespace App\Http\Controllers\Admin;

use App\Exports\businessExport;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use App\Models\Category;
use App\Models\Language;
use App\Models\Country;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\DefaultLogo;
use App\Models\SubCategory;
use App\Models\Province;
use App\Models\City;
use App\Models\BusinessGallery;
use Illuminate\Http\Request;
use App\Http\Repositories\BusinessRepository;
use App\Http\Requests\BusinessRequest;
use App\Http\Requests\BusinessCategoryRequest;
use App\Http\Requests\BusinessLanguageRequest;
use App\Http\Requests\BusinessPaymentRequest;
use App\Http\Requests\BusinessSubCategoryRequest;
use Maatwebsite\Excel\Facades\Excel;

class BusinessController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $packages = Package::orderBy("name","asc")->where("status",1)->get();
        $categories = Category::orderBy("name","asc")->where("status",1)->get();
        $businesses = Business::orderBy("name","desc")->with("business_upgrade_latest");
        if($request->sts!=''){
            $businesses->where("status",$request->sts);
        }
        if($request->province_id!=''){
            $businesses->where("province_id",$request->province_id);
        }
        if($request->category_id!=''){
            $category_id=$request->category_id;
            $businesses->whereHas('category', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        }
        if($request->package_id!=''){
            $package_id=$request->package_id;
            $businesses->whereHas('business_upgrade_latest', function ($query) use ($package_id) {
                $query->where('package_id', $package_id);
            });
        }
        if($request->status == "active"){
            $businesses->where("status",1);
        }elseif($request->status == "inactive"){
            $businesses->where("status",0);
        }elseif($request->status == "expired"){
            $businesses->whereHas("business_upgrade_latest", function ($query) {
                $query->where('expired_date', '<=', date('Y-m-d'));
            });
        }elseif($request->status == "upcomming"){
            $businesses->whereHas("business_upgrade_latest", function ($query) {
                $query->where('expired_date', '>=', date('Y-m-d'));
            });
        }elseif($request->status == "premium"){
            $businesses->whereHas("business_upgrade_latest", function ($query) {
                $query->where('package_id', 1);
                $query->where('expired_date', '>=', date("Y-m-d"));
            });
        }
        $businesses = $businesses->get();
        // dd($businesses[0]->business_upgrade_latest->expired_date,date("d-m-Y"),$businesses[0]->business_upgrade_latest->expired_date<date("d-m-Y"));

        $default_logo = DefaultLogo::where("status", 1)->latest()->first();
        return view('Backend.Admin.Business.list', compact('businesses','default_logo','packages','categories'));
    }

    public function export(Request $request){
        return Excel::download(new businessExport($request), 'Business.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy("fname","asc")->where("status",1)->get();
        $categories = Category::orderBy("name","asc")->where("status",1)->get();
        $languages = Language::orderBy("name","asc")->where("status",1)->get();
        $countries = Country::orderBy("name","asc")->where("status",1)->get();
        $packages = Package::orderBy("name","asc")->where("status",1)->get();
        $paymentMethods = PaymentMethod::orderBy("name","asc")->where("status",1)->get();
        return view('Backend.Admin.Business.create',compact('users','categories','languages','countries','packages','paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        BusinessRepository $repository,
        BusinessRequest $request1,
        BusinessCategoryRequest $request2,
        BusinessSubCategoryRequest $request3,
        BusinessLanguageRequest $request4,
        BusinessPaymentRequest $request5
        )
    {

        $result =  $repository->store(
            $request1,
            $request2,
            $request3,
            $request4,
            $request5
        );

        if($result){
            $repository->business_admin_email_confirmation($request1);
            $repository->business_user_email_confirmation($request1);
        }

        return redirect(route('admin.business.index'))->with('success', 'Business added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        $default_logo = DefaultLogo::where("status", 1)->latest()->first();
        return view('Backend.Admin.Business.show', compact('business','default_logo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        $users = User::orderBy("fname","asc")->where("status",1)->get();
        $categories = Category::orderBy("name","asc")->where("status",1)->get();
        $languages = Language::orderBy("name","asc")->where("status",1)->get();
        $countries = Country::orderBy("name","asc")->where("status",1)->get();
        $packages = Package::orderBy("name","asc")->where("status",1)->get();
        $paymentMethods = PaymentMethod::orderBy("name","asc")->where("status",1)->get();

        $subCategories = SubCategory::where("category_id",$business->category->category_id)->get();
        $provinces = Province::where("country_id",$business->country_id)->get();
        $cities = City::where("province_id",$business->province_id)->get();

        return view('Backend.Admin.Business.edit', compact(
            'business',
            'users',
            'categories',
            'languages',
            'countries',
            'packages',
            'paymentMethods',
            'subCategories',
            'provinces',
            'cities',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(
        BusinessRepository $repository,
        BusinessRequest $request1,
        BusinessCategoryRequest $request2,
        BusinessSubCategoryRequest $request3,
        BusinessLanguageRequest $request4,
        BusinessPaymentRequest $request5,
        Business $business
        )
    {

        $result =  $repository->update(
            $request1,
            $request2,
            $request3,
            $request4,
            $request5,
            $business
        );

        // if($result){
        //     $repository->business_admin_email_confirmation($request1);
        //     $repository->business_user_email_confirmation($request1);
        // }

        return redirect(route('admin.business.index'))->with('success', 'Business updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        // $business->delete();
        // return redirect(route('admin.business.index'))->with('success', 'Default logo deleted successfully!');
    }

    public function status_change(Request $request)
    {
        Business::where("id", $request->id)->update(["status" => (($request->status == 1) ? 0 : 1)]);
        return redirect(route('admin.business.index'))->with('success', 'Default logo updated successfully!');
    }

    public function isFeature_change(Request $request)
    {
        Business::where("id", $request->id)->update(["is_feature" => (($request->is_feature == 1) ? 0 : 1)]);
        return redirect(route('admin.business.index'))->with('success', 'Business updated successfully!');
    }

    public function gallery_upload(BusinessRepository $repository,Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000'
        ]);
       return $repository->gallery_upload($request);
    }

    public function gallery_remove(Request $request)
    {
        if(BusinessGallery::where("id",$request->id)->delete()){
            echo "success";
        }
        exit;
    }
}
