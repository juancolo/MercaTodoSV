<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('products/{product}', 'ProductController@show')
    ->name('api.v1.products.show');
Route::get('products', 'ProductController@index')
    ->name('api.v1.products.index');*/

JsonApi::register('v1')->routes(function ($api){
    $api->resource('products');
});
