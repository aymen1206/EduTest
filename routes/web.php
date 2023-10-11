<?php

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function()
{
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    Route::get('/', 'App\Http\Controllers\HomeController@index')->name('homepage');
    Route::get('/faq', 'App\Http\Controllers\HomeController@faq');
    Route::get('/about', 'App\Http\Controllers\HomeController@about');
    Route::get('/tamara', 'App\Http\Controllers\HomeController@tamara');
    Route::get('/tabby', 'App\Http\Controllers\HomeController@tabby');
    Route::get('/jeel', 'App\Http\Controllers\HomeController@jeel');
    Route::get('/facilities/{id}', 'App\Http\Controllers\HomeController@eduFacilities');
    Route::get('/facility/{id}', 'App\Http\Controllers\HomeController@Facility');
    Route::get('/search', 'App\Http\Controllers\SearchController@search');
    Route::get('/terms', 'App\Http\Controllers\HomeController@terms');
    Route::get('contact','App\Http\Controllers\HomeController@contact');
    Route::get('offers','App\Http\Controllers\OfferController@offers');
    Route::get('offer/{id}','App\Http\Controllers\OfferController@offer');
    Route::get('forget-password','App\Http\Controllers\HomeController@forgetPassword');


    Route::get('edu-facility/register', 'App\Http\Controllers\EduFacility\Auth\RegisterController@showRegistrationForm')->name('get_edu_facility_register');

});
Route::put('edu-facility/order','App\Http\Controllers\EduFacility\OrderController@update')->name('edu-facility.order');
Route::post('send-message','App\Http\Controllers\HomeController@sendMessage');
Route::post('login','App\Http\Controllers\GeneralLoginController@index');

Route::get('getSectors','App\Http\Controllers\TapPaymentController@getSectors');
Route::get('createFile','App\Http\Controllers\TapPaymentController@createFile');
Route::get('createBusiness','App\Http\Controllers\TapPaymentController@createBusiness');
Route::get('createMarketPlace','App\Http\Controllers\TapPaymentController@createMarketPlace');

Route::get('successful-payment', 'App\Http\Controllers\Student\PaymentController@checkPayment');
Route::get('tamara-success' , 'App\Http\Controllers\Student\PaymentController@TamaraCallback');
Route::get('tamara-cancel' , 'App\Http\Controllers\Student\PaymentController@TamaraCallbackCancelation');
Route::get('tamara-failure' , 'App\Http\Controllers\Student\PaymentController@TamaraCallback');
Route::get('testDestinationID', 'App\Http\Controllers\Student\PaymentController@testDestinationID');
Route::post('tamara-notification', 'App\Http\Controllers\Student\PaymentController@tamaraNotification')->withoutMiddleware([VerifyCsrfToken::class]);
