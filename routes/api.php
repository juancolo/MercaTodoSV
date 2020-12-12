<?php

use Illuminate\Support\Facades\Route;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use CloudCreativity\LaravelJsonApi\Routing\RouteRegistrar;

JsonApi::register('v1')->routes(function (RouteRegistrar$api){
    $api->resource('products')
        ->relationships(function ($api){$api->hasOne('categories');})
        ->middleware('auth:sanctum');
    $api->resource('categories')
        ->middleware('auth:sanctum');
});

Route::post('/api/v1/auth', 'AuthController@login')
    ->name('api.v1.login.user');


