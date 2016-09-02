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

/*Za registraciju i prijavu*/
Route::auth();
/*Pocetna stranica*/
Route::get('/', 'HomeController@index');
/*Dohvat cijene*/
Route::get('order/getPrice','OrderController@getPrice')->name('getPrice');
/*Rezervacije prijavljenog korisnika*/
Route::get('user/reservations','UserController@getOrders');
/*CRUD operacije za admina*/
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
{
    Route::resource('taxi','TaxiController');
    Route::resource('user','UserController');
    Route::resource('order','OrderController');
});
/*Omogucuje korisniku spremanje narudzbe u bazu podataka*/
Route::post('order','OrderController@store');


