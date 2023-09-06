<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessUser\ForgotPasswordController;
use App\Http\Controllers\BusinessUser\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('login', [AuthController::class, 'businessUserLoginCheck'])->name('login');


Route::group(['middleware' => 'auth:business_user'], function () {
    //logout
    Route::post('logout', [AuthController::class, 'businessUserLogout'])->name('logout');

    //profile
    Route::get('profile', [DashboardController::class, 'index'])->name('profile');
    Route::get('profile/{user}/edit', [DashboardController::class, 'edit'])->name('profile.edit');
    Route::put('profile/{user}/update', [DashboardController::class, 'update'])->name('profile.update');

    //wishlist
    Route::get('wishlist', [DashboardController::class, 'wishlist'])->name('wishlist');
});

//password reset
Route::get('forgot-password', [ForgotPasswordController::class, 'password_form_view'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'password_email'])->name('password.email');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'password_reset_form'])->name('password.reset');
Route::post('forgot-password/update', [ForgotPasswordController::class, 'reset_password'])->name('password.update');
