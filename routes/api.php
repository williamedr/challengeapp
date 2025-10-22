<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;


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

	Route::resource('orders', OrderController::class);

});


