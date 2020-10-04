<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes(['verify'=>true]);

//User Admin
Route::resource('/admin',  'Admin\UserController');

//Products Admin
Route::resource('/product', 'Admin\ProductController');

Route::resource('/shop', 'ShopController');


//store
Route::group( ['prefix' => 'store'], function (){
    Route::get('/landing', 'StoreController@landing')
        ->name('client.landing');
    Route::get('/landing/products', 'StoreController@showProducts')
        ->name('client.product');
    Route::get('/landing/products/espeficiaciones/{product}', 'StoreController@showSpecs')
        ->name('client.product.specs');
    Route::post('/cart/{product}', 'Store\CartController@store')
        ->name('cart.store');
    Route::get('/cart', 'Store\CartController@index')
        ->name('cart.index');
    Route::get('/cart/{product}', 'Store\CartController@update')
        ->name('cart.update');
    Route::delete('/cart/{product}', 'Store\CartController@destroy')
        ->name('cart.destroy');
});

//Payments
Route::get('payment/index/{user}', 'PaymentController@index')->name('payment.index');
Route::post('payment/store', 'PaymentController@store')->name('payment.store');
Route::view('/webcheckout', 'webcheckout.index');

//Try routes
Route::post('payment/storeprueba', 'PaymentController@storePrueba')->name('payment.storeprueba');
Route::get('show/storeprueba', 'PaymentController@show')->name('payment.show');

