<?php

use Illuminate\Support\Facades\Route;

Route::get('/',[\App\Http\Controllers\DeviceController::class,'index'])->name('index');
