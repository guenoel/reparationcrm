<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProfileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/devices', [DeviceController::class, 'store']);
Route::get('/devices', [DeviceController::class, 'index']);

Route::get('/devices/{device}/edit', [DeviceController::class, 'edit']);

Route::put('/devices/{device}', [DeviceController::class, 'update']);
Route::delete('/devices/{device}', [DeviceController::class,'destroy']);


//test
Route::resource('devices', DeviceController::class);
Route::resource('users', ProfileController::class);