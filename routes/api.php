<?php

use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// ---------------- HomeController ----------------
Route::post('get_language', [HomeController::class, 'get_language'])->name('get-language');
Route::post('cast_detail', [HomeController::class, 'cast_detail'])->name('cast-detail');
Route::post('get_category', [HomeController::class, 'get_category'])->name('get-category');
Route::post('get_banner', [HomeController::class, 'get_banner'])->name('get-banner');
Route::post('general_setting', [HomeController::class, 'general_setting'])->name('general-setting');
Route::post('get_type', [HomeController::class, 'get_type'])->name('get-type');
Route::post('get_avatar', [HomeController::class, 'get_avatar'])->name('get-avatar');
Route::post('section_list', [HomeController::class, 'section_list'])->name('section-list');
Route::post('section_detail', [HomeController::class, 'section_detail'])->name('section-detail');
Route::post('add_continue_watching', [HomeController::class, 'add_continue_watching'])->name('add-continue-watching');
Route::post('remove_continue_watching', [HomeController::class, 'remove_continue_watching'])->name('remove-continue-watching');
Route::post('add_remove_bookmark', [HomeController::class, 'add_remove_bookmark'])->name('add-remove-bookmark');
Route::post('add_remove_download', [HomeController::class, 'add_remove_download'])->name('add-remove-download');
Route::post('add_transaction', [HomeController::class, 'add_transaction'])->name('add-transaction');
Route::post('add_rent_transaction', [HomeController::class, 'add_rent_transaction'])->name('add-rent-transaction');
Route::post('video_by_category', [HomeController::class, 'video_by_category'])->name('video-by-category');
Route::post('video_by_language', [HomeController::class, 'video_by_language'])->name('video-by-language');
Route::post('get_bookmark_video', [HomeController::class, 'get_bookmark_video'])->name('get-bookmark-video');
Route::post('search_video', [HomeController::class, 'search_video'])->name('search-video');
Route::post('user_rent_video_list', [HomeController::class, 'user_rent_video_list'])->name('user-rent-video-list');
Route::post('rent_video_list', [HomeController::class, 'rent_video_list'])->name('rent-video-list');
Route::post('get_payment_option', [HomeController::class, 'get_payment_option'])->name('get-payment-option');
Route::post('get_video_by_session_id', [HomeController::class, 'get_video_by_session_id'])->name('get-video-by-session-id');
Route::post('get_package', [HomeController::class, 'get_package'])->name('get-package');
Route::post('get_payment_token', [HomeController::class, 'get_payment_token'])->name('get-payment-token');
Route::post('apply_coupon', [HomeController::class, 'apply_coupon'])->name('apply_coupon');
Route::post('subscription_list', [HomeController::class, 'subscription_list'])->name('subscription_list');

// ---------------- ChannelController ----------------
Route::post('get_channel', [ChannelController::class, 'get_channel'])->name('get-channel');
Route::post('channel_section_list', [ChannelController::class, 'channel_section_list'])->name('channel-section-list');

// ---------------- UsersController ----------------
Route::post('login', [UserController::class, 'login'])->name('api-login');
Route::post('registration', [UserController::class, 'registration'])->name('api-registration');
Route::post('get_profile', [UserController::class, 'get_profile'])->name('get-profile');
Route::post('update_profile', [UserController::class, 'update_profile'])->name('update-profile');
Route::post('image_upload', [UserController::class, 'image_upload'])->name('image-upload');
