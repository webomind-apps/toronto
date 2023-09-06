<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\User;
use App\Models\BusinessUser;
use App\Models\Country;
use App\Models\Province;
use App\Models\City;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allBusinesses = Business::count();

        $allActiveBusinesses = Business::with("business_upgrade_latest")
        ->whereHas("business_upgrade_latest",function($query){
            $query->where("expired_date","<=",date("Y-m-d"));
        })
        ->where("status",1)
        ->count();

        $allInactiveBusinesses = Business::with("business_upgrade_latest")
        ->where("status",0)
        ->count();

        $allExpiredBusinesses = Business::with("business_upgrade_latest")
        ->whereHas("business_upgrade_latest",function($query){
            $query->where("expired_date",">=",date("Y-m-d"));
        })
        ->where("status",1)
        ->count();

        $allUsers= User::count();
        $allActiveUsers= User::where("status",1)->count();
        $allInactiveUsers= User::where("status",0)->count();

        $allBusinessUsers= BusinessUser::count();
        $allActiveBusinessUsers= BusinessUser::where("status",1)->count();
        $allInactiveBusinessUsers= BusinessUser::where("status",0)->count();

        $allActivePremiumBusinesses = Business::with("business_upgrade_latest")
        ->whereHas("business_upgrade_latest",function($query){
            $query->where("expired_date","<=",date("Y-m-d"));
            $query->where("package_id",1);
        })
        ->where("status",1)
        ->count();

        $allActiveAdvertisement= Advertisement::where("status",1)->count();
        $allInactiveActiveAdvertisement= Advertisement::where("status",0)->count();

        $allCounties= Country::count();

        $allProvinces= Province::count();

        $allCities= City::count();

        return view('Backend.Admin.Dashboard.index',compact(
            'allBusinesses',
            'allActiveBusinesses',
            'allInactiveBusinesses',
            'allExpiredBusinesses',
            'allUsers',
            'allActiveUsers',
            'allInactiveUsers',
            'allBusinessUsers',
            'allActiveBusinessUsers',
            'allInactiveBusinessUsers',
            'allActivePremiumBusinesses',
            'allActiveAdvertisement',
            'allInactiveActiveAdvertisement',
            'allCounties',
            'allProvinces',
            'allCities',

        ));
    }

}
