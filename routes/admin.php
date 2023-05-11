<?php

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

// Login-Logout
Route::get('admin/login', 'Auth\AdminController@getLogin')->name('adminLogin');
Route::post('login', 'Auth\AdminController@postLogin')->name('adminLoginPost');
Route::get('admin/logout', 'Auth\AdminController@logout')->name('adminLogout');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'authadmin'], function () {

    Route::group(['middleware' => 'checkadmin'], function () {

        // Type
        Route::get('type/add', 'TypeController@add')->name('typeAdd');
        Route::post('type/save', 'TypeController@save')->name('typeSave');
        Route::get('type/edit/{id}', 'TypeController@edit')->name('editType');
        Route::post('type/update', 'TypeController@update')->name('typeUpdate');
        Route::get('type/delete/{id}', 'TypeController@delete')->name('deleteType');
        // Category
        Route::get('category/add', 'CategoryController@add')->name('categoryAdd');
        Route::post('category/save', 'CategoryController@save')->name('categorySave');
        Route::get('category/edit/{id}', 'CategoryController@edit')->name('editCategory');
        Route::post('category/update', 'CategoryController@update')->name('categoryUpdate');
        Route::get('category/delete/{id}', 'CategoryController@delete')->name('deleteCategory');
        // Avatar
        Route::get('avatar/add', 'AvatarController@add')->name('AvatarAdd');
        Route::post('avatar/save', 'AvatarController@save')->name('AvatarSave');
        Route::get('avatar/edit/{id}', 'AvatarController@edit')->name('editAvatar');
        Route::post('avatar/update', 'AvatarController@update')->name('AvatarUpdate');
        Route::get('avatar/delete/{id}', 'AvatarController@delete')->name('deleteAvatar');
        // Language
        Route::get('language/add', 'LanguageController@add')->name('languageAdd');
        Route::post('language/save', 'LanguageController@save')->name('languageSave');
        Route::get('language/edit/{id}', 'LanguageController@edit')->name('editLanguage');
        Route::post('language/update', 'LanguageController@update')->name('languageUpdate');
        Route::get('language/delete/{id}', 'LanguageController@delete')->name('deleteLanguage');
        // Session
        Route::get('session/add', 'SessionController@add')->name('sessionAdd');
        Route::post('session/save', 'SessionController@save')->name('sessionSave');
        Route::get('session/edit/{id}', 'SessionController@edit')->name('editSession');
        Route::post('session/update', 'SessionController@update')->name('sessionUpdate');
        Route::get('session/delete/{id}', 'SessionController@delete')->name('deleteSession');
        // Page
        Route::get('page/edit/{id}', 'PageController@edit')->name('editPage');
        Route::post('page/update', 'PageController@update')->name('PageUpdate');
        // Channel
        Route::get('channel/add', 'ChannelController@add')->name('channelAdd');
        Route::post('channel/save', 'ChannelController@save')->name('channelSave');
        Route::get('channel/edit/{id}', 'ChannelController@edit')->name('editChannel');
        Route::post('channel/update', 'ChannelController@update')->name('channelUpdate');
        Route::get('channel/delete/{id}', 'ChannelController@delete')->name('deleteChannel');
        // Channel Banner
        Route::get('Channel-Banner/add', 'ChannelBannerlController@add')->name('ChannelBannerAdd');
        Route::post('Channel-Banner/save', 'ChannelBannerlController@save')->name('ChannelBannerSave');
        Route::get('Channel-Banner/edit/{id}', 'ChannelBannerlController@edit')->name('editChannelBanner');
        Route::post('Channel-Banner/update', 'ChannelBannerlController@update')->name('ChannelBannerUpdate');
        Route::get('Channel-Banner/delete/{id}', 'ChannelBannerlController@delete')->name('deleteChannelBanner');
        // User
        Route::get('user/add', 'UserController@add')->name('userAdd');
        Route::post('user/save', 'UserController@save')->name('userSave');
        Route::get('user/edit/{id}', 'UserController@edit')->name('editUser');
        Route::post('user/update', 'UserController@update')->name('userUpdate');
        Route::get('user/delete/{id}', 'UserController@delete')->name('deleteUser');
        // Cast
        Route::get('cast/add', 'CastController@add')->name('castAdd');
        Route::post('cast/save', 'CastController@save')->name('castSave');
        Route::get('cast/edit/{id}', 'CastController@edit')->name('editCast');
        Route::post('cast/update', 'CastController@update')->name('castUpdate');
        Route::get('cast/delete/{id}', 'CastController@delete')->name('deleteCast');
        // Video
        Route::get('video/add', 'VideoController@add')->name('videoAdd');
        Route::post('video/save', 'VideoController@save')->name('videoSave');
        Route::get('video/edit/{id}', 'VideoController@edit')->name('editVideo');
        Route::post('video/update', 'VideoController@update')->name('videoUpdate');
        Route::get('video/delete/{id}', 'VideoController@delete')->name('deleteVideo');
        // Chunk route
        Route::any('saveChunk', 'VideoController@saveChunk');
        // TV Show
        Route::get('TVShow/add', 'TVShowController@add')->name('TVShowAdd');
        Route::post('TVShow/save', 'TVShowController@save')->name('TVShowSave');
        Route::get('TVShow/edit/{id}', 'TVShowController@edit')->name('editTVShow');
        Route::post('TVShow/update', 'TVShowController@update')->name('TVShowUpdate');
        Route::get('TVShow/delete/{id}', 'TVShowController@delete')->name('deleteTVShow');
        // TV Show Video
        Route::get('TVShow/videos/add/{id}', 'TVShowController@TVShowvideoadd')->name('TVShowvideoAdd');
        Route::post('TVShow/videos/save', 'TVShowController@TVShowvideosave')->name('TVShow_video_Save');
        Route::get('TVShow/video/edit/{show_id}/{id}', 'TVShowController@TVShowvideoedit')->name('editTVShow_video');
        Route::post('TVShow/video/update/{show_id}/{id}', 'TVShowController@TVShowvideoupdate')->name('TVShow_videoUpdate');
        Route::get('TVShow/video/delete/{id}', 'TVShowController@TVShowvideodelete')->name('deleteTVShow_video');
        // Rent
        Route::get('rent/add', 'RentVideoController@add')->name('RentVideoAdd');
        Route::post('rent/save', 'RentVideoController@save')->name('RentVideoSave');
        Route::get('rent/edit/{id}', 'RentVideoController@edit')->name('editRentVideo');
        Route::post('rent/update', 'RentVideoController@update')->name('RentVideoUpdate');
        Route::get('rent/delete/{id}', 'RentVideoController@delete')->name('deleteRentVideo');
        // Packages (plan Subscription)
        Route::get('packages/add', 'PackageController@add')->name('packageAdd');
        Route::post('packages/save', 'PackageController@save')->name('packageSave');
        Route::get('packages/edit/{id}', 'PackageController@edit')->name('editPackage');
        Route::post('packages/update', 'PackageController@update')->name('packageUpdate');
        Route::get('packages/delete/{id}', 'PackageController@delete')->name('deletePackage');
        // Payment
        Route::get('payment/edit/{id}', 'PaymentVideoController@edit')->name('editPayment');
        Route::post('payment/update', 'PaymentVideoController@update')->name('PaymentUpdate');
        // Notification
        Route::get('notification/add', 'NotificationController@add')->name('notificationAdd');
        Route::post('notification/save', 'NotificationController@save')->name('notificationSave');
        Route::get('notification/setting', 'NotificationController@setting')->name('notificationSetting');
        Route::post('notification/setting/add', 'NotificationController@settingsave')->name('notificationSettingsave');
        Route::get('notification/delete/{id}', 'NotificationController@delete')->name('deleteNotification');
        // Coupons
        Route::get('coupon/add', 'CouponController@add')->name('couponAdd');
        Route::post('coupon/save', 'CouponController@save')->name('couponSave');

        Route::get('coupon/random/add', 'CouponController@randomAdd')->name('couponRandomAdd');
        Route::post('coupon/random/save', 'CouponController@randomSave')->name('couponRandomSave');

        Route::get('coupon/edit/{id}', 'CouponController@edit')->name('editCoupon');
        Route::post('coupon/update', 'CouponController@update')->name('couponUpdate');
        Route::get('coupon/delete/{id}', 'CouponController@delete')->name('deleteCoupon');

    });

    // Home
    Route::get('/home', 'AdminController@dashboard')->name('Home');
    // Dashboard
    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
    // Type
    Route::get('type', 'TypeController@index')->name('type');
    Route::get('type/data', 'TypeController@data')->name('typeData');
    // Category
    Route::get('category', 'CategoryController@index')->name('category');
    Route::get('category/data', 'CategoryController@data')->name('categoryData');
    // Avatar
    Route::get('avatar', 'AvatarController@index')->name('Avatar');
    Route::get('avatar/data', 'AvatarController@data')->name('AvatarData');
    // Language
    Route::get('language', 'LanguageController@index')->name('language');
    Route::get('language/data', 'LanguageController@data')->name('languageData');
    // Session
    Route::get('session', 'SessionController@index')->name('session');
    Route::get('session/data', 'SessionController@data')->name('sessionData');
    // Page
    Route::get('page', 'PageController@index')->name('Page');
    Route::get('page/data', 'PageController@data')->name('PageData');
    // Video Banner
    Route::get('banner', 'BannerController@index')->name('Banner');
    Route::post('banner/typebyvideo', 'BannerController@TypeByVideo')->name('BannerTypeByVideo');
    Route::post('banner/list', 'BannerController@BannerList')->name('BannerList');
    Route::post('banner/save', 'BannerController@save')->name('BannerSave');
    Route::post('banner/delete/{id}', 'BannerController@delete')->name('deleteBanner');
    // Video Section
    Route::get('VideoSection', 'VideoSectionController@index')->name('VideoSection');
    Route::post('VideoSection/save', 'VideoSectionController@save')->name('VideoSectionSave');
    Route::post('VideoSection/update', 'VideoSectionController@update')->name('VideoSectionUpdate');
    Route::post('VideoSection/update1', 'VideoSectionController@update1')->name('VideoSectionUpdate1');
    Route::get('VideoSection/delete/{id}', 'VideoSectionController@delete')->name('deleteVideoSection');
    Route::get('VideoSection/get_lang_or_cat', 'VideoSectionController@get_lang_or_cat')->name('GetLangOrCat');
    Route::post('VideoSection/data', 'VideoSectionController@GetSectionData')->name('GetSectionData');
    // Channel
    Route::get('channel', 'ChannelController@index')->name('channel');
    Route::get('channel/data', 'ChannelController@data')->name('channelData');
    // Channel Banner
    Route::get('Channel-Banner', 'ChannelBannerlController@index')->name('ChannelBanner');
    Route::get('Channel-Banner/data', 'ChannelBannerlController@data')->name('ChannelBannerData');
    // Channel Section
    Route::get('ChannelSection', 'ChannelSectionController@index')->name('ChannelSection');
    Route::post('ChannelSection/save', 'ChannelSectionController@save')->name('ChannelSectionSave');
    Route::post('ChannelSection/update', 'ChannelSectionController@update')->name('ChannelSectionUpdate');
    Route::post('ChannelSection/update1', 'ChannelSectionController@update1')->name('ChannelSectionUpdate1');
    Route::get('ChannelSection/delete/{id}', 'ChannelSectionController@delete')->name('deleteChannelSection');
    Route::get('ChannelSection/get_lang_or_cat', 'ChannelSectionController@get_lang_or_cat')->name('ChannelGetLangOrCat');
    Route::post('ChannelSection/data', 'ChannelSectionController@GetSectionData')->name('ChannelGetSectionData');
    // User
    Route::get('user', 'UserController@index')->name('user');
    Route::get('user/data', 'UserController@data')->name('userData');
    // Cast
    Route::get('cast', 'CastController@index')->name('cast');
    Route::get('cast/data', 'CastController@data')->name('castData');
    // Video
    Route::get('video', 'VideoController@index')->name('video');
    Route::get('video/data', 'VideoController@data')->name('videoData');
    Route::get('video/details/{id}', 'VideoController@detail')->name('videoDetail');
    Route::get('TVShow/videos/{id}/serach', 'TVShowController@TVShowVideoSerach')->name('TVShowVideoSerach');
    // TV Show
    Route::get('TVShow', 'TVShowController@index')->name('TVShow');
    Route::get('TVShow/data', 'TVShowController@data')->name('TVShowData');
    Route::get('TVShow/details/{id}', 'TVShowController@TVShowDetail')->name('TVShowDetail');
    // TV Show Video
    Route::get('TVShow/videos/{id}', 'TVShowController@TVShowvideo')->name('TVShowvideo');
    // Rent
    Route::get('rent', 'RentVideoController@index')->name('RentVideo');
    Route::get('rent/data', 'RentVideoController@data')->name('RentVideoData');
    // Setting (Master)
    Route::get('setting', 'SettingController@index')->name('setting');
    Route::post('setting/app', 'SettingController@app')->name('settingapp');
    Route::post('setting/currency', 'SettingController@currency')->name('settingcurrency');
    Route::post('setting/changepassword', 'SettingController@changepassword')->name('settingchangepassword');
    Route::post('setting/admob', 'SettingController@admob_android')->name('settingadmob_android');
    Route::post('setting/admob-ios', 'SettingController@admob_ios')->name('settingadmob_ios');
    Route::post('setting/facebookad', 'SettingController@facebookad')->name('settingfacebookad');
    Route::post('setting/facebookad-ios', 'SettingController@facebookad_ios')->name('settingfacebookad_ios');
    Route::get('setting/smtp', 'SettingController@smtpindex')->name('settingsmtpindex');
    Route::post('setting/smtp', 'SettingController@smtp')->name('settingsmtp');
    // Packages (plan Subscription)
    Route::get('packages', 'PackageController@index')->name('package');
    Route::get('packages/data', 'PackageController@data')->name('packageData');
    // Payment
    Route::get('payment', 'PaymentVideoController@index')->name('Payment');
    Route::get('payment/data', 'PaymentVideoController@data')->name('PaymentData');
    // Notification
    Route::get('notification', 'NotificationController@index')->name('notification');
    Route::get('notification/data', 'NotificationController@data')->name('notificationData');
    // IMDB (Video)
    Route::post('serachname/{txtVal}', 'VideoController@SerachName')->name('SerachName');
    Route::post('getdata/{id}', 'VideoController@GetData')->name('GetData');
    // IMDB (TVShow)
    Route::post('tvshow/serachname/{txtVal}', 'TVShowController@SerachName')->name('TVshowSerachName');
    Route::post('tvshow/getdata/{id}', 'TVShowController@GetData')->name('TVshowGetData');
    // Transaction
    Route::get('transaction', 'TransactionController@index')->name('transaction');
    Route::get('transaction/data', 'TransactionController@data')->name('TransactionData');

    // Coupons
    Route::get('coupon', 'CouponController@index')->name('coupon');
    Route::get('coupon/data', 'CouponController@data')->name('couponData');

});
