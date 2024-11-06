<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'index');

Route::get('/devices', [\App\Http\Controllers\DeviceController::class, 'index'])->name('devices.index');
Route::get('/devices/create', [\App\Http\Controllers\DeviceController::class, 'create'])->name('devices.create');
Route::post('/devices', [\App\Http\Controllers\DeviceController::class, 'store'])->name('devices.store');
Route::get('/devices/edit/{device}', [\App\Http\Controllers\DeviceController::class, 'edit'])->name('devices.edit');
Route::put('/devices/{device}', [\App\Http\Controllers\DeviceController::class, 'update'])->name('devices.update');
Route::delete('/devices/{device}', [\App\Http\Controllers\DeviceController::class, 'destroy'])->name('devices.destroy');