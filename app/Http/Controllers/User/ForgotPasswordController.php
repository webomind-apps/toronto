<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserResetPasswordLink;
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
        return view('Backend.User.ForgotPassword.index');
    }

    public function password_email(Request $request)
    {

        //You can add validation login here
        $user = User::where('email', $request->email)->latest()->first();
        //Check if the user exists
        if (empty($user)) {
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

        if ($this->sendResetEmail($user, $tokenData)) {
            return redirect()->back()->with('status', trans('We have emailed your password reset link!'));
        } else {
            return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
        }
    }

    private function sendResetEmail($user, $token)
    {
        //Generate, the password reset link. The token generated is embedded in the link
        $link = url('/user/reset-password/') . '/' . $token . '?email=' . urlencode($user->email);
        // $link = route("user.password.reset",$token,["email=>".urlencode($user->email)]);
        try {
            //Here send the link with CURL with an external email API
            Notification::send($user, new UserResetPasswordLink($link));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function password_reset_form(Request $request, $token = null)
    {
        return view('Backend.User.ForgotPassword.reset', compact('request'));
    }

    public function reset_password(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8|max:20',
            'token' => 'required',
        ]);

        $password = $request->password;
        // Validate the token
        $tokenData = DB::table('password_resets')
            ->where('token', $request->token)->latest()->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) {
            return redirect(route("user.password.request"));
        }

         $user = User::where('email', $tokenData->email)->latest()->first();
        // Redirect the user back if the email is invalid
        if (! $user) {
            return redirect()->back()->withErrors(['email' => 'Email not found']);
        }

        //Hash and update the new password
         $user->password = Hash::make($password);
         $user->update(); //or  $user->save();

        //Delete the token
        DB::table('password_resets')->where('email',  $user->email)
            ->delete();

        return redirect(route("home.index"))->with('pop-up-success', 'Your password has been reset!');
    }
}
