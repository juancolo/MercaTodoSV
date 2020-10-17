<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('client.landing');
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
Route::group(['prefix'=> 'payment'], function (){
    Route::get('/index/{user}', 'PaymentController@index')
        ->name('payment.index');
    Route::post('/payment', 'PaymentController@store')
        ->name('payment.store');
    Route::get('/endtransaction/{order}', 'PaymentController@endTransaction' )
        ->name('payment.endTransaction');
    Route::post('/payment/{order}', 'PaymentController@reDonePayment')
        ->name('payment.redone');
});


