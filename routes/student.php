<?php

use Illuminate\Support\Facades\Route;


// Dashboard
Route::get('/', 'HomeController@index')->name('home');

// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');


Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Register
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');


// Reset Password
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');


// Confirm Password
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');

//profile change password
Route::get('change-password', 'HomeController@changePassword');
Route::post('change-password', 'HomeController@changePasswordPost')->name('st_reset_password');

// favorites
Route::get('favorites', 'FavoritesController@index');
Route::get('/remove-from-favorite/{id}', 'FavoritesController@removeFromFavorite');
Route::get('/add-to-favorite/{id}', 'FavoritesController@addToFavorite');

// notifications
Route::get('notifications', 'NotificationController@index');

// notifications
Route::get('profile', 'CustomAuthcontroller@profile');


// orders
Route::get('orders', 'OrderController@index');
Route::get('make-order/{id}/{pr_id}', 'OrderController@create');
Route::get('tabby-success/{id}', 'OrderController@Tabbysuccess');
Route::get('tabby-cancel', 'OrderController@Tabbycancel');
Route::get('tabby-failure', 'OrderController@Tabbyfailure');
Route::get('Jeel-Payment/{id}', 'OrderController@JeelResponse');
Route::get('jeel-installments/{order_id}', 'PaymentController@jeelPay');

Route::get('get-payment-methods/{order_id}', 'PaymentController@getPaymentMethods');
Route::get('pay/{order_id}/{method_id}', 'PaymentController@requesPaymentLink');
Route::get('successful-payment', 'PaymentController@checkPayment');
Route::get('invoice/{invoice_id}/{order_id}', 'PaymentController@invoice');


Route::get('tamara-payment/{order_id}', 'PaymentController@tamaraPayment');
Route::get('alrajhi-installments/{order_id}', 'PaymentController@alrajhiInstallements');
Route::post('alrajhi-installments/{order_id}', 'PaymentController@createAlrajhiInstallements');

Route::get('tamara/{order_id}', 'PaymentController@Tamara');
Route::get('tamara/invoice/{order_id}', 'PaymentController@TamaraInvoice');


Route::get('tabby/{order_id}', 'PaymentController@tabbyPayment');
Route::get('tabby-payment/{order_id}', 'PaymentController@TabbyPreScoring');


Route::resource('childrens', 'ChildrenController');
Route::get('childrens/{id}/delete', 'ChildrenController@destroy');


Route::post('login', 'Auth\LoginController@login')->name('st_login');
Route::post('register', 'CustomAuthcontroller@register')->name('st_register');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm')->name('password_confirm');
Route::post('profile', 'CustomAuthcontroller@updateProfile')->name('st_profile');
Route::post('make-order', 'OrderController@store')->name('makeorder');
Route::post('childrens/complete-account', 'CustomAuthcontroller@completeAccountData')->name('childrens_complete_account');
Route::post('make-order/complete-account', 'CustomAuthcontroller@completeAccountOrder')->name('make_order_complete_account');
Route::post('rate', 'HomeController@rate')->name('rate');
Route::get('/Skip-rate/{facility_ID}/skip', 'HomeController@skipRate');

// Verify Email
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
// Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
//

Route::get('phone/verify', 'PhoneAuthController@index');
Route::get('phone/verify/{id}/{hash}', 'PhoneAuthController@verify');
Route::post('phone/resend', 'PhoneAuthController@resend');
Route::get('phone-auth', 'PhoneAuthController@index');
Route::get('otp-success', 'PhoneAuthController@otpSuccess');

