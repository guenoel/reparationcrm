<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//DEVICES
Route::post('/devices', [DeviceController::class, 'store']);
Route::get('/devices', [DeviceController::class, 'index']);
Route::get('/devices/{device}/edit', [DeviceController::class, 'edit']);
Route::put('/devices/{device}', [DeviceController::class, 'update']);
Route::delete('/devices/{device}', [DeviceController::class,'destroy']);

//SERVICES
Route::post('/services', [ServiceController::class, 'store']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}/edit', [ServiceController::class, 'edit']);
Route::put('/services/{service}', [ServiceController::class, 'update']);
Route::delete('/services/{service}', [ServiceController::class,'destroy']);

//test
Route::resource('services', ServiceController::class);
Route::resource('devices', DeviceController::class);
Route::resource('users', ProfileController::class);