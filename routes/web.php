<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=>true]);

Route::get('/', 'HomeController@index')->name('home')->middleware('verified');
Route::view('/home', 'store.landing')->name('store.landing');
Route::resource('/admin', 'UserController');
Route::resource('/product', 'ProductController');
Route::get('/shop', 'ShopController@index')->name('shop.index');
