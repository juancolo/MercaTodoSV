<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=>true]);

Route::get('/', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/shop2', 'ShopController@create');
Route::resource('/admin',  'UserController');
Route::resource('/product', 'ProductController');
Route::view('/category','admin.createCategory');
Route::get('/shop', 'ShopController@index')->name('shop.index');
