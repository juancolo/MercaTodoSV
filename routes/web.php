<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=>true]);

<<<<<<< Updated upstream
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
=======
Route::get('/', 'HomeController@index')->name('home')->middleware('verified');
Route::view('/home', 'store.landing')->name('store.landing');
Route::resource('/admin', 'UserController');

>>>>>>> Stashed changes
