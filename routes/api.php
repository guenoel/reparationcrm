<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SpareController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SparetypeController;
use App\Http\Controllers\UserController;

// Route::resource('spare_types', SparetypeController::class);
// Route::resource('spares', SpareController::class);
// Route::resource('tasks', TaskController::class);
// Route::resource('services', ServiceController::class);
// Route::resource('devices', DeviceController::class);
// Route::resource('users', UserController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    //USERS
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}/edit', [UserController::class, 'edit']);
    Route::put('/users/{user}', [UserController::class, 'update']);

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

    //TASKS
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class,'destroy']);

    //SPARES
    Route::post('/spares', [SpareController::class, 'store']);
    Route::get('/spares', [SpareController::class, 'index']);
    Route::get('/spares/{spare}/edit', [SpareController::class, 'edit']);
    Route::put('/spares/{spare}', [SpareController::class, 'update']);
    Route::delete('/spares/{spare}', [SpareController::class,'destroy']);

    //SPARES TYPES
    Route::post('/spare_types', [SpareTypeController::class, 'store']);
    Route::get('/spare_types', [SpareTypeController::class, 'index']);
    Route::get('/spare_types/{spare_type}/edit', [SpareTypeController::class, 'edit']);
    Route::put('/spare_types/{spare_type}', [SpareTypeController::class, 'update']);
    Route::delete('/spare_types/{spare_type}', [SpareTypeController::class,'destroy']);
});

Route::get('/debug', function (Request $request) {
    return response()->json([
        'auth_user' => Auth::user(),
        'session' => session()->all(),
        'cookies' => $request->cookies->all(),
    ]);
});