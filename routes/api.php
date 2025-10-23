<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Middleware\CheckClient;

Route::get('/test', function () {
	return "Test";
});


Route::group(['prefix' => 'auth'], function() {

	Route::post('register', [AuthController::class, 'register']);

	Route::post('login', [AuthController::class, 'login']);

	Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

});


Route::group(['middleware' => ['auth:sanctum']], function() {

	Route::get('/user', function (Request $request) {
		return $request->user();
	});

	Route::resource('products', ProductController::class);

	Route::get('clients/{client}/orders', [ClientController::class, 'orders']);

	Route::get('notifications', [InvoiceController::class, 'notifications']);

});



Route::group(['middleware' => ['auth:sanctum', CheckClient::class]], function() {

	Route::resource('orders', OrderController::class)->except('show');
	Route::get('orders/{id}', [OrderController::class, 'show']);

	Route::resource('invoices', InvoiceController::class)->except('show');
	Route::get('invoices/{id}', [InvoiceController::class, 'show']);

	Route::resource('clients', ClientController::class);

	Route::get('clients/{client}/orders', [ClientController::class, 'orders']);

});


