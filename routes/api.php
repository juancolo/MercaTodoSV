<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use CloudCreativity\LaravelJsonApi\Routing\RouteRegistrar;

JsonApi::register('v1')->routes(function (RouteRegistrar$api){
    $api->resource('products',[
        'middleware'=>'auth:api'
    ])
        ->relationships(function ($api){
            $api->hasOne('categories');
        });
    $api->resource('categories',[
        'middleware'=>'auth:api'
    ]);
});
