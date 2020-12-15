<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('client.landing');
})->name('welcome');

Auth::routes(['verify' => true]);

//User Admin
Route::resource('/admin', 'Admin\UserController')
    ->parameter('admin', 'user')
    ->except('show');
Route::get('/admin/user/export', 'Admin\ExportController@userExport')
    ->name('user.export');
//ProductStatus Admin
Route::post('/product/export', 'Admin\ExportController@productExport')
    ->name('product.export');
Route::post('/product/import', 'Admin\ImportController@productImport')
    ->name('product.import');
Route::resource('/product', 'Admin\ProductController')
    ->except('show');

//store
Route::group(['prefix' => 'store'], function () {
    Route::get('/landing', 'Store\StoreController@landing')
        ->name('client.landing');
    Route::get('/landing/products', 'Store\StoreController@showProducts')
        ->name('client.product');
    Route::get('/landing/products/espeficiaciones/{product}', 'Store\StoreController@showSpecs')
        ->name('client.product.specs');
    Route::get('/cart', 'Store\CartController@index')
        ->name('cart.index');
    Route::post('/cart/{product}', 'Store\CartController@store')
        ->name('cart.store');
    Route::get('/cart/{product}', 'Store\CartController@update')
        ->name('cart.update');
    Route::delete('/cart/{product}', 'Store\CartController@destroy')
        ->name('cart.destroy');
});

//Payments
Route::group(['prefix' => 'payment'], function () {
    Route::get('/index/{user}', 'Ecomerce\PaymentController@index')
        ->name('payment.index');
    Route::post('/payment', 'Ecomerce\PaymentController@store')
        ->name('payment.store');
    Route::get('/end_transaction/{order}', 'Ecomerce\PaymentController@endTransaction')
        ->name('payment.endTransaction');
    Route::post('/payment/{order}', 'Ecomerce\PaymentController@reDonePayment')
        ->name('payment.redone');
});

//Order
Route::group(['prefix' => 'order'], function () {
    Route::get('/show', 'Ecomerce\OrderController@show')
        ->name('order.show');
});

Route::resource('admin/order', 'Admin\OrdersController@index')
    ->except('create', 'show', 'delete');

