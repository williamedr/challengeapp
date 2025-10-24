<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Middleware\CheckClient;
use App\Http\Middleware\CheckUser;


Route::get('/health', function () {
	return "Ok";
});


Route::group(['prefix' => 'auth'], function() {

	Route::post('register', [AuthController::class, 'register']);

	Route::post('login', [AuthController::class, 'login']);

	Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

});


Route::group(['middleware' => ['auth:sanctum']], function() {


	Route::get('/test', function (Request $request) {
		return "Test Authenticated";
	});


	Route::get('/user', function (Request $request) {
		return $request->user();
	});

	Route::resource('products', ProductController::class);

	Route::get('clients/{client}/orders', [ClientController::class, 'orders']);

	Route::get('notifications', [InvoiceController::class, 'notifications']);

});



Route::group(['middleware' => ['auth:sanctum', CheckClient::class]], function() {

	Route::resource('orders', OrderController::class)->middleware(CheckUser::class);

	Route::resource('invoices', InvoiceController::class)->middleware(CheckUser::class);

	Route::resource('clients', ClientController::class);

	Route::get('clients/{client}/orders', [ClientController::class, 'orders']);

});


