<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\BusinessController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\ReviewController;
use Illuminate\Support\Facades\Route;

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
Route::post('login', [AuthController::class, 'userLoginCheck'])->name('login');

Route::group(['middleware' => 'auth:user'], function () {

    // dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //business
    Route::post('business/galleryUpload', [BusinessController::class, 'gallery_upload'])->name('business.galleryUpload');
    Route::get('business/galleryRemove', [BusinessController::class, 'gallery_remove'])->name('business.galleryRemove');
    Route::resource('business', BusinessController::class, ['except' => ['create']]);

    // //business user
    // Route::put('business/user/status', [BusinessUserController::class, 'status_change'])->name('business.user.status');
    // Route::get('business/user/index', [BusinessUserController::class, 'index'])->name('business.user.index');
    // Route::get('business/user/show', [BusinessUserController::class, 'show'])->name('business.user.show');

    //booking
    Route::put('booking/status', [BookingController::class, 'status_change'])->name('booking.status');
    Route::get('booking/index', [BookingController::class, 'index'])->name('booking.index');
    Route::get('booking/show', [BookingController::class, 'show'])->name('booking.show');

    //review
    Route::get('review/index', [ReviewController::class, 'index'])->name('review.index');
    Route::put('review/status', [ReviewController::class, 'status_change'])->name('review.status');
    Route::get('review/show', [ReviewController::class, 'show'])->name('review.show');

    //common function
    Route::post('common/email_unique', [CommonController::class, 'email_unique'])->name('common.email_unique');
    Route::get('common/email_unique', [CommonController::class, 'email_unique'])->name('common.email_unique');
    Route::get('common/subCategory/collection', [CommonController::class, 'subCategory_collection'])->name('common.subCategory.collection');
    Route::get('common/province/collection', [CommonController::class, 'province_collection'])->name('common.province.collection');
    Route::get('common/city/collection', [CommonController::class, 'city_collection'])->name('common.city.collection');

    //logout
    Route::post('logout', [AuthController::class, 'userLogout'])->name('logout');
});

//password reset
Route::get('forgot-password', [ForgotPasswordController::class, 'password_form_view'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'password_email'])->name('password.email');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'password_reset_form'])->name('password.reset');
Route::post('forgot-password/update', [ForgotPasswordController::class, 'reset_password'])->name('password.update');
