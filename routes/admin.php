<?php

use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\BusinessUserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DefaultLogoController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\FooterContentController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\HeaderBannerController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommonController;
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
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'adminLoginCheck'])->name('login');

Route::group(['middleware' => 'auth:admin'], function () {

    //dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //category
    Route::put('category/status', [CategoryController::class, 'status_change'])->name('category.status');
    Route::resource('category', CategoryController::class);

    //sub category
    Route::put('subCategory/status', [SubCategoryController::class, 'status_change'])->name('subCategory.status');
    Route::resource('subCategory', SubCategoryController::class);

    //language
    Route::put('language/status', [LanguageController::class, 'status_change'])->name('language.status');
    Route::resource('language', LanguageController::class);

    //default logo
    Route::put('defaultLogo/status', [DefaultLogoController::class, 'status_change'])->name('defaultLogo.status');
    Route::resource('defaultLogo', DefaultLogoController::class);

    //footer content
    Route::put('footerContent/status', [FooterContentController::class, 'status_change'])->name('footerContent.status');
    Route::resource('footerContent', FooterContentController::class);

    //advertisement
    Route::put('advertisement/status', [LanguageController::class, 'status_change'])->name('advertisement.status');
    Route::resource('advertisement', AdvertisementController::class);

    //package
    Route::put('package/price', [PackageController::class, 'price_change'])->name('package.price');
    Route::put('package/status', [PackageController::class, 'status_change'])->name('package.status');
    Route::resource('package', PackageController::class);

    //country
    Route::put('country/status', [CountryController::class, 'status_change'])->name('country.status');
    Route::resource('country', CountryController::class);

    //province
    Route::put('province/status', [ProvinceController::class, 'status_change'])->name('province.status');
    Route::resource('province', ProvinceController::class);

    //city
    Route::put('city/status', [CityController::class, 'status_change'])->name('city.status');
    Route::resource('city', CityController::class);

    //user
    Route::put('user/status', [UserController::class, 'status_change'])->name('user.status');
    Route::get('user/index', [UserController::class, 'index'])->name('user.index');
    Route::get('user/show/{user}', [UserController::class, 'show'])->name('user.show');

    //business user
    Route::put('business/user/status', [BusinessUserController::class, 'status_change'])->name('business.user.status');
    Route::get('business/user/index', [BusinessUserController::class, 'index'])->name('business.user.index');
    Route::get('business/user/show', [BusinessUserController::class, 'show'])->name('business.user.show');

    //booking
    Route::put('booking/status', [BookingController::class, 'status_change'])->name('booking.status');
    Route::get('booking/index', [BookingController::class, 'index'])->name('booking.index');
    Route::get('booking/show', [BookingController::class, 'show'])->name('booking.show');

    //review
    Route::get('review/index', [ReviewController::class, 'index'])->name('review.index');
    Route::put('review/status', [ReviewController::class, 'status_change'])->name('review.status');
    Route::get('review/show', [ReviewController::class, 'show'])->name('review.show');

    //Enquiry
    Route::get('enquiry/index', [EnquiryController::class, 'index'])->name('enquiry.index');

    //header banner
    Route::put('headerBanner/status', [HeaderBannerController::class, 'status_change'])->name('headerBanner.status');
    Route::resource('headerBanner', HeaderBannerController::class);

    //business
    Route::put('business/status', [BusinessController::class, 'status_change'])->name('business.status');
    Route::put('business/isFeature', [BusinessController::class, 'isFeature_change'])->name('business.isFeature');
    Route::post('business/galleryUpload', [BusinessController::class, 'gallery_upload'])->name('business.galleryUpload');
    Route::get('business/galleryRemove', [BusinessController::class, 'gallery_remove'])->name('business.galleryRemove');
    Route::resource('business', BusinessController::class);

    //payment method
    Route::put('paymentMethod/status', [PaymentMethodController::class, 'status_change'])->name('paymentMethod.status');
    Route::resource('paymentMethod', PaymentMethodController::class);

    //common function
    Route::post('common/email_unique', [CommonController::class, 'email_unique'])->name('common.email_unique');
    Route::get('common/email_unique', [CommonController::class, 'email_unique'])->name('common.email_unique');
    Route::get('common/subCategory/collection', [CommonController::class, 'subCategory_collection'])->name('common.subCategory.collection');
    Route::get('common/province/collection', [CommonController::class, 'province_collection'])->name('common.province.collection');
    Route::get('common/city/collection', [CommonController::class, 'city_collection'])->name('common.city.collection');

    //logout
    Route::post('logout', [AuthController::class, 'adminLogout'])->name('logout');

});

//password reset
Route::get('forgot-password', [ForgotPasswordController::class, 'password_form_view'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'password_email'])->name('password.email');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'password_reset_form'])->name('password.reset');
Route::post('forgot-password/update', [ForgotPasswordController::class, 'reset_password'])->name('password.update');
