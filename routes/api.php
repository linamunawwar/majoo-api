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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');
Route::get('logout', 'UserController@logout');


Route::middleware('jwt.verify')->group(function () {
    Route::get('merchant', 'MerchantController@index');
    Route::post('merchant/new', 'MerchantController@store');
	Route::delete('merchant/delete/{id}', 'MerchantController@delete');
	Route::get('outlet', 'OutletController@index');
    Route::post('outlet/new', 'OutletController@store');
	Route::delete('outlet/delete/{id}', 'OutletController@delete');
	// Route::get('user', 'UserController@getAuthenticatedUser');
	Route::get('transaction/getMerchant/{month}/{year}', 'TransactionController@getByMerchant');
	Route::get('transaction/getMerchantOutlet/{month}/{year}', 'TransactionController@getByMerchantOutlet');
});