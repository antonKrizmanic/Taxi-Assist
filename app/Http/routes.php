<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/', 'HomeController@index');

Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
{
    Route::resource('taxi','TaxiController');
    Route::resource('user','UserController');
    Route::resource('order','OrderController');
});

Route::post('order','OrderController@store');
Route::get('order/getPrice/{distance}','OrderController@getPrice')->name('getPrice');
Route::get('reservations','HomeController@getOrders');
