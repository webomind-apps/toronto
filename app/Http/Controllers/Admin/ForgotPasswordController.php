<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\AdminResetPasswordLink;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function password_form_view()
    {
        return view('Backend.Admin.ForgotPassword.index');
    }

    public function password_email(Request $request)
    {

        //You can add validation login here
        $admin = Admin::where('email', $request->email)->latest()->first();
        //Check if the user exists
        if (empty($admin)) {
            return redirect()->back()->withErrors(['email' => trans("We can't find a user with that email address.")]);
        }

        //Get the token just created above
        $tokenData = Str::random(60);

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $tokenData,
            'created_at' => Carbon::now(),
        ]);

        if ($this->sendResetEmail($admin, $tokenData)) {
            return redirect()->back()->with('status', trans('We have emailed your password reset link!'));
        } else {
            return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
        }
    }

    private function sendResetEmail($admin, $token)
    {
        //Generate, the password reset link. The token generated is embedded in the link
        $link = url('/admin/reset-password/') . '/' . $token . '?email=' . urlencode($admin->email);
        // $link = route("admin.password.reset",$token,["email=>".urlencode($admin->email)]);
        try {
            //Here send the link with CURL with an external email API
            Notification::send($admin, new AdminResetPasswordLink($link));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function password_reset_form(Request $request, $token = null)
    {
        return view('Backend.Admin.ForgotPassword.reset', compact('request'));
    }

    public function reset_password(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|confirmed|min:8|max:20',
            'token' => 'required',
        ]);

        $password = $request->password;
        // Validate the token
        $tokenData = DB::table('password_resets')
            ->where('token', $request->token)->latest()->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) {
            return redirect(route("admin.password.request"));
        }

         $admin = Admin::where('email', $tokenData->email)->latest()->first();
        // Redirect the user back if the email is invalid
        if (! $admin) {
            return redirect()->back()->withErrors(['email' => 'Email not found']);
        }

        //Hash and update the new password
         $admin->password = Hash::make($password);
         $admin->update(); //or  $admin->save();

        //Delete the token
        DB::table('password_resets')->where('email',  $admin->email)
            ->delete();

        return redirect(route("admin.login"))->with('status', 'Your password has been reset!');
    }
}
