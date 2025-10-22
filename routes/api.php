<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

	Route::get('/products', [ProductController::class, 'index']);

});


