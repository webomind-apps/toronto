<?php

namespace App\Http\Controllers\BusinessUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\BusinessUser;
use App\Models\Business;
use App\Models\DefaultLogo;
use App\Http\Requests\BusinessUserRegistrationRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = $this->search_categories();
        return view("Frontend.BusinessUser.Dashboard.index", compact('categories'));
    }

    public function edit(BusinessUser $user)
    {
        $categories = $this->search_categories();
        return view("Frontend.BusinessUser.Dashboard.edit", compact('categories','user'));
    }

    public function update(BusinessUserRegistrationRequest $request,BusinessUser $user)
    {
        $user->update($request->validated());
        return redirect(route("business.user.profile.edit",$user));
    }

   
    public function wishlist()
    {
        $categories = $this->search_categories();
        $businesses = Business::with('wishLists');
            $businesses->whereHas("wishLists", function ($query) {
                $query->where('business_user_id',user()->id);
            });
        $businesses=$businesses->paginate(10);
        $default_logo = DefaultLogo::where("status", 1)->latest()->first();
        return view("Frontend.BusinessUser.Dashboard.wishlist", compact('businesses','categories','default_logo'));
    }

    public function search_categories()
    {
        return Category::where("status", 1)->where("priority", "!=", "")->orderBy("priority", "asc")->get();
    }

}
