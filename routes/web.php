<?php

use App\Http\Controllers\Admin\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\CommonController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!Backend.Admin.SubCategory.create
|
*/

// Route::middleware(['auth:sanctum', 'verified'])->group(function () {

// });


//Front end controller
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/blogs', [HomeController::class, 'blogs'])->name('home.blogs');
Route::get('blog/{id}/details', [BlogController::class, 'show'])->name('blog.details');

//registration
Route::prefix('registration/')->name('registration.')->group(function () {

    Route::get('step1', [HomeController::class, 'registration_step1'])->name('step1');
    Route::get('step2', [HomeController::class, 'registration_step2'])->name('step2');
    Route::get('step3', [HomeController::class, 'registration_step3'])->name('step3');
    Route::get('step4', [HomeController::class, 'registration_step4'])->name('step4');

    Route::post('step1', [HomeController::class, 'registration_submit_step1'])->name('submit.step1');
    Route::post('step2', [HomeController::class, 'registration_submit_step2'])->name('submit.step2');
    Route::post('step3', [HomeController::class, 'registration_submit_step3'])->name('submit.step3');
    Route::post('step4', [HomeController::class, 'registration_submit_step4'])->name('submit.step4');
});

//home page
Route::get('listing/page', [HomeController::class, 'listing_page'])->name('listing.page');
Route::get('detail/page/{business}', [HomeController::class, 'detail_page'])->name('detail.page');
Route::get('home/search/category/collection', [CommonController::class, 'home_search_category_collection'])->name('home.search.category.collection');
Route::get('business/review/terms-and-condition', [HomeController::class, 'business_review_terms_and_condition'])->name('business.review.terms.conditions');
Route::get('advertise-with-us', [HomeController::class, 'advertise_with_us'])->name('advertise.with.us');
Route::get('contact/us', [HomeController::class, 'contact_us'])->name('contact.us');

//Front end post
Route::post('booking/appointment', [HomeController::class, 'booking_appointment'])->name('booking.appointment');
Route::post('business/review', [HomeController::class, 'business_review'])->name('business.review');
Route::post('business/add/favourite', [HomeController::class, 'business_add_favourite'])->name('business.add.favourite');
Route::post('contact/submit', [HomeController::class, 'contact_submit'])->name('contact.submit');
Route::post('business/user/registration', [HomeController::class, 'business_user_registration'])->name('business.user.registration');

//review
Route::get('review/confirmation', [HomeController::class, 'review_confirmation'])->name('review.confirmation');
Route::get('review/email/unique', [HomeController::class, 'review_email_unique'])->name('review.email.unique');

//common function
Route::prefix('common/')->name('common.')->group(function () {
    Route::post('footer_content', [CommonController::class, 'footer_content'])->name('footer_content');
    Route::post('email_unique', [CommonController::class, 'email_unique'])->name('email_unique');
    Route::get('subCategory/collection', [CommonController::class, 'subCategory_collection'])->name('subCategory.collection');
    Route::get('province/collection', [CommonController::class, 'province_collection'])->name('province.collection');
    Route::get('city/collection', [CommonController::class, 'city_collection'])->name('city.collection');
    Route::post('search/category/collection', [CommonController::class, 'search_category_collection'])->name('search.category.collection');
    Route::post('search/city/collection', [CommonController::class, 'search_city_collection'])->name('search.city.collection');
});

Route::get('browse-by-category', [HomeController::class, 'browse_by_category'])->name('browse.by.category');
Route::get('browse-by-location', [HomeController::class, 'browse_by_location'])->name('browse.by.location');

Route::get('email-test', [HomeController::class, 'email_test']);

