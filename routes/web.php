<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=>true]);

//Oficial routes
Route::resource('/admin',  'Admin\UserController');
Route::resource('/shop', 'ShopController');
Route::resource('/product', 'Admin\ProductController');

Route::group( ['prefix' => 'store'], function (){
    Route::get('/landing', 'StoreController@landing')->name('client.landing');
    Route::get('/landing/products', 'StoreController@showProducts')->name('client.product');
    Route::get('/landing/products/espeficiaciones/{product}', 'StoreController@showSpecs')->name('client.product.specs');
});

//Try routes
//Route::get('/category','Admin\ProductController@edit');
//Route::get('/prodshow', 'ProductController@index');
Route::get('/', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/shop2', 'ShopController@create');
