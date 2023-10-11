<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

// Dashboard
Route::get('/', 'HomeController@index')->name('home');

// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


Route::post('register', 'CustomAuthController@register')->name('fa_register');

// Reset Password
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Confirm Password
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

// Verify Email
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
// Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');


//----------------------- profile -----------------------------
Route::get('profile/show','ProfileController@show');
Route::get('profile','ProfileController@profile');
Route::post('profile','ProfileController@updateProfile');

 Route::get('finance','ProfileController@finance');
 Route::post('finance/update','ProfileController@financeUpdate');

//--------------------------- Password reset -----------------
Route::get('reset-password','ProfileController@getResetPassword');
Route::post('reset-password','ProfileController@ResetPassword');

//----------------------- Orders -----------------------------------
Route::resource('orders','OrderController');
Route::get('orders/accept-tamara/{id}','OrderController@autorize');

Route::resource('gallery','GalleryController');
Route::get('gallery/{id}/delete','GalleryController@destroy');

//----------------------- Orders -----------------------------------
// Route::resource('ads','FacilityAdController');
// Route::get('ads/{id}/delete','FacilityAdController@destroy');

//------------------------------ Financial Records ------------------------------
Route::get('financial','FacilityFinancialRecordController@index');
Route::get('financial-logs','FacilityFinancialRecordController@logs');

//------------------------- Withdrawal Logs -----------------------------
Route::resource('withdrawal-logs','FacilityWithdrawalLogController');

//--------------------------- Prices ---------------------------------------
Route::resource('prices','FacilityPriceController');
Route::get('prices/{id}/delete','FacilityPriceController@destroy');

//------------------------- delete sp ---------------------------------
Route::get('sp/delete/{id}','ProfileController@deleteSp');

Route::get('get_facility_types/{id}','HomeController@getFacilityTypes');
Route::get('get_stages/{id}','HomeController@getFacilityStages');
Route::get('get_payment_methods/{id}','HomeController@getPymentMethod');
//----------------------- messages -----------------------------------
Route::resource('messages','MessagesController');
//----------------------- rating -----------------------------------
Route::resource('ratings','RatingController');
Route::get('rate/{id}/status','RatingController@activeInactive');
Route::post('rate','RatingController@rate');

Route::get('notification','NotificationController@index');
Route::get('notification/{id}','NotificationController@show');
