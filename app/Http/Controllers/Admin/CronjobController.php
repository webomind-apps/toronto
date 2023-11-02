<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Notifications\PackageExpiryNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CronjobController extends Controller
{
    public function expiryReminder()
    {
        $today = date("Y-m-d");
        $sixtyth_date = date('d-m-Y', strtotime('+60 days', strtotime($today)));
        $thirtyth_date = date('d-m-Y', strtotime('+30 days', strtotime($today)));
        $fifteenth_date = date('d-m-Y', strtotime('+15 days', strtotime($today)));
        $businesses = Business::where('status', 1)->get();
        foreach ($businesses as $business) {
            $expiry_date = $business->business_upgrade_latest->expired_date;
            if ($expiry_date == $fifteenth_date) {
                $content = [
                    "greeting" => "Hi ".$business->user->fname.' '.$business->user->lname,
                    "subject" => "Toronto Connection | Package Expiry Reminder",
                    "content" => "your subscription will be going to expiry in 15 days.",
                ];
                Notification::route("mail", $business->email)->notify(new PackageExpiryNotification($content));
            }elseif ($expiry_date == $thirtyth_date) {
                $content = [
                    "greeting" => "Hi ".$business->user->fname.' '.$business->user->lname,
                    "subject" => "Toronto Connection | Package Expiry Reminder",
                    "content" => "your subscription will be going to expiry in 30 days.",
                ];
                Notification::route("mail", $business->email)->notify(new PackageExpiryNotification($content));
            }elseif ($expiry_date == $sixtyth_date) {
                $content = [
                    "greeting" => "Hi ".$business->user->fname.' '.$business->user->lname,
                    "subject" => "Toronto Connection | Package Expiry Reminder",
                    "content" => "your subscription will be going to expiry in 60 days.",
                ];
                Notification::route("mail", $business->email)->notify(new PackageExpiryNotification($content));
            }
        }
    }
}
