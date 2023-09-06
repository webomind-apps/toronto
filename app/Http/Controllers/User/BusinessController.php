<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use App\Models\Category;
use App\Models\Language;
use App\Models\Country;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\DefaultLogo;
use App\Models\Subcategory;
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

class BusinessController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $businesses = Business::orderBy("id","asc")->where("user_id",user()->id)->get();

        $default_logo = DefaultLogo::where("status", 1)->latest()->first();
        return view('Backend.User.Business.list', compact('businesses','default_logo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        return view('Backend.User.Business.show', compact('business'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        if($business->user_id != user()->id){
            abort(404);
        }
        $users = User::orderBy("fname","asc")->where("status",1)->get();
        $categories = Category::orderBy("name","asc")->where("status",1)->get();
        $languages = Language::orderBy("name","asc")->where("status",1)->get();
        $countries = Country::orderBy("name","asc")->where("status",1)->get();
        $packages = Package::orderBy("name","asc")->where("status",1)->get();
        $paymentMethods = PaymentMethod::orderBy("name","asc")->where("status",1)->get();

        $subCategories = Subcategory::where("category_id",$business->category->category_id)->get();
        $provinces = Province::where("country_id",$business->country_id)->get();
        $cities = City::where("province_id",$business->province_id)->get();

        return view('Backend.User.Business.edit', compact(
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
        if($business->user_id != user()->id){
            abort(404);
        }

        $result =  $repository->update(
            $request1,
            $request2,
            $request3,
            $request4,
            $request5,
            $business
        );

        // if($result){
        //     $repository->business_user_email_confirmation($request1);
        //     $repository->business_user_email_confirmation($request1);
        // }

        return redirect(route('user.business.index'))->with('success', 'Business updated successfully!');
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
        // return redirect(route('user.business.index'))->with('success', 'Default logo deleted successfully!');
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
