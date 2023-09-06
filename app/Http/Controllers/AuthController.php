<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend.Admin.Login.index');
    }

    public function AdminLoginCheck(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password,'status'=>1], $request->get('remember'))) {
            return redirect(route("admin.dashboard"));
        }
        return back()->withInput($request->only('email', 'remember'))->with('error', 'Invalid Credential');
    }

    public function userLoginCheck(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password,'status'=>1], $request->get('remember'))) {
            return redirect(route("user.business.index"));
        }
        return back()->withInput($request->only('email', 'remember'))->with('user-error', 'Invalid Credential');
    }

    public function businessUserLoginCheck(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('business_user')->attempt(['email' => $request->email, 'password' => $request->password,'status'=>1], $request->get('remember'))) {
            return back();
        }
        return back()->withInput($request->only('email', 'remember'))->with('business-user-error', 'Invalid Credential');
    }

    public function adminLogout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function userLogout()
    {
        Auth::logout();
        return redirect()->route('home.index');
    }

    public function businessUserLogout()
    {
        Auth::logout();
        return redirect()->route('home.index');
    }


}
