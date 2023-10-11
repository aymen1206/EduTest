<?php

use Illuminate\Http\Request;
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

use App\Http\Controllers\Api\StudentJWTAuthController;
use App\Http\Controllers\Api\FacilityJWTAuthController;
use App\Http\Controllers\Api\HomeController;

Route::get('/index', 'App\Http\Controllers\Api\HomeController@index')->name('homepage');
Route::get('/about', 'App\Http\Controllers\Api\HomeController@about');
Route::get('/facility/{id}', 'App\Http\Controllers\Api\HomeController@Facility');
Route::get('/terms', 'App\Http\Controllers\Api\HomeController@terms');
Route::post('send-message', 'App\Http\Controllers\Api\HomeController@sendMessage');
Route::get('/search', 'App\Http\Controllers\Api\SearchController@search');
Route::post('/jeel/webhook/', 'App\Http\Controllers\Api\HomeController@jeelwebhook');

Route::get('offers', 'App\Http\Controllers\Api\HomeController@offers');
Route::get('offer/{id}', 'App\Http\Controllers\Api\HomeController@offer');
Route::get('price-list', 'App\Http\Controllers\Api\HomeController@priceList');

Route::get('all-facility-types', 'App\Http\Controllers\Api\HomeController@allFacilityTypes');
Route::get('facility-type-data', 'App\Http\Controllers\Api\HomeController@facilityTypeData');

Route::get('stages', [HomeController::class, 'stages']);
Route::get('settings', [App\Http\Controllers\Api\HomeController::class, 'settings']);

Route::get('classes', [HomeController::class, 'classes']);
Route::get('get-all-class-for-one-stage', [App\Http\Controllers\Api\HomeController::class, 'allClass']);
Route::get('get-all-payments-for-one-stage', [App\Http\Controllers\Api\HomeController::class, 'allPayment']);

Route::get('get-all-filter-data', [App\Http\Controllers\Api\HomeController::class, 'filterdata']);

Route::get('all-cities', [HomeController::class, 'allCities']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'student-auth'

], function () {
    
 Route::post('password-reset-with-email', [StudentJWTAuthController::class, 'forgot'])->name('password.email');
    
    Route::post('login', [StudentJWTAuthController::class, 'login']);
    Route::post('register', [StudentJWTAuthController::class, 'register']);
    Route::post('logout', [StudentJWTAuthController::class, 'logout']);
    Route::post('refresh', [StudentJWTAuthController::class, 'refresh']);
    Route::get('profile', [StudentJWTAuthController::class, 'profile']);
    Route::post('reset-password', [StudentJWTAuthController::class, 'resetPassword']);
    Route::post('update-profile', [StudentJWTAuthController::class, 'updateProfile']);
    Route::post('complete-account-data', [StudentJWTAuthController::class, 'completeAccountData']);
    Route::post('complete-account-on-order', [StudentJWTAuthController::class, 'completeAccountOrder']);

    Route::get('children', [StudentJWTAuthController::class, 'children']);
    Route::post('add-child', [StudentJWTAuthController::class, 'storeChild']);
    Route::get('child', [StudentJWTAuthController::class, 'child']);
    Route::post('update-child', [StudentJWTAuthController::class, 'updateChild']);
    Route::post('delete-child', [StudentJWTAuthController::class, 'deleteChild']);

    Route::get('favorites', [StudentJWTAuthController::class, 'favorites']);
    Route::post('add-to-favorite', [StudentJWTAuthController::class, 'addToFavorite']);
    Route::post('remove-from-favorite', [StudentJWTAuthController::class, 'removeFromFavorite']);
  Route::post('remove-from-favorite-by-facility-id', [StudentJWTAuthController::class, 'removeFromFavoriteByFacility']);

    Route::get('notifications', [StudentJWTAuthController::class, 'notifications']);

    Route::get('orders', [StudentJWTAuthController::class, 'orders']);
    Route::post('add-order', [StudentJWTAuthController::class, 'addOrder']);
    Route::get('show-order', [StudentJWTAuthController::class, 'showOrder']);
  	Route::get('payment-url', [StudentJWTAuthController::class, 'PaymentUrl']);
    
    Route::get('order-payment-option',[StudentJWTAuthController::class, 'TamaraOrder']);
  
   Route::get('facility/{id}', [StudentJWTAuthController::class, 'facility']);
   Route::get('facilities', [StudentJWTAuthController::class, 'facilities']);
   Route::post('invoice', [StudentJWTAuthController::class, 'invoice']);
  
   Route::post('tamara-success' ,[StudentJWTAuthController::class, 'TamaraCallback']);
   Route::post('tamara-cancel' ,[StudentJWTAuthController::class, 'TamaraCallbackCancelation']);
   Route::post('tamara-failure' ,[StudentJWTAuthController::class, 'TamaraCallback']);
   Route::post('testDestinationID',[StudentJWTAuthController::class, 'testDestinationID']);
   Route::post('tamara-notification',[StudentJWTAuthController::class, 'tamaraNotification']);
  
  
    

});


Route::group([
    'middleware' => ['api'],
    'prefix' => 'facility-auth'

], function () {
    
     Route::post('password-reset-with-email', [FacilityJWTAuthController::class, 'forgot']);
    Route::post('login', [FacilityJWTAuthController::class, 'login']);
    Route::post('register', [FacilityJWTAuthController::class, 'register']);
    Route::post('logout', [FacilityJWTAuthController::class, 'logout']);
    Route::post('refresh', [FacilityJWTAuthController::class, 'refresh']);
    Route::get('profile', [FacilityJWTAuthController::class, 'profile']);
    Route::post('update-profile', [FacilityJWTAuthController::class, 'updateProfile']);
    Route::post('reset-password', [FacilityJWTAuthController::class, 'resetPassword']);
    Route::get('gallery', [FacilityJWTAuthController::class, 'gallery']);
    Route::post('add-image-to-gallery', [FacilityJWTAuthController::class, 'addImageToGallery']);
    Route::post('remove-image-from-gallery', [FacilityJWTAuthController::class, 'removeImageFromGallery']);

    Route::get('logs', [FacilityJWTAuthController::class, 'logs']);
    Route::get('withdrawal-logs', [FacilityJWTAuthController::class, 'withdrawalLogs']);
    Route::post('add-withdrawal-request', [FacilityJWTAuthController::class, 'addWithdrawalRequest']);
    Route::get('financial-records', [FacilityJWTAuthController::class, 'financialRecords']);

    Route::get('get-all-stages', [FacilityJWTAuthController::class, 'createPrice']);


    Route::get('index', [FacilityJWTAuthController::class, 'index']);


    Route::get('all-prices', [FacilityJWTAuthController::class, 'allPrices']);


    Route::post('store-price', [FacilityJWTAuthController::class, 'storePrice']);
    Route::get('show-price', [FacilityJWTAuthController::class, 'showPrice']);
    Route::get('edit-price', [FacilityJWTAuthController::class, 'editPrice']);
    Route::post('update-price', [FacilityJWTAuthController::class, 'updatePrice']);
    Route::get('delete-price', [FacilityJWTAuthController::class, 'destroyPrice']);

    Route::get('notifications', [FacilityJWTAuthController::class, 'notifications']);
    Route::get('ratings', [FacilityJWTAuthController::class, 'ratings']);
    Route::get('messages', [FacilityJWTAuthController::class, 'messages']);


    Route::get('all-orders', [FacilityJWTAuthController::class, 'orders']);
    Route::get('show-order', [FacilityJWTAuthController::class, 'showOrder']);
    Route::post('update-order', [FacilityJWTAuthController::class, 'updateOrder']);
    Route::post('delete-order', [FacilityJWTAuthController::class, 'destroyOrder']);


    Route::get('favorites', [FacilityJWTAuthController::class, 'favorites']);
    Route::post('add-to-favorite', [FacilityJWTAuthController::class, 'addToFavorite']);
    Route::post('remove-from-favorite', [FacilityJWTAuthController::class, 'removeFromFavorite']);


    Route::get('orders', [FacilityJWTAuthController::class, 'orders']);
    Route::post('add-order', [FacilityJWTAuthController::class, 'addOrder']);

});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
