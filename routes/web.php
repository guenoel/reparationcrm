<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
//use App\Http\Controllers\DeviceController;
//use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

//DASHBOARDS
Route::get('/admin/dashboard', function () {
    return Inertia::render('Dashboard_Admin');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard_admin');

Route::get('/worker/dashboard', function () {
    return Inertia::render('Dashboard_Worker');
})->middleware(['auth', 'verified', 'worker'])->name('dashboard_worker');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'customer'])->name('dashboard');

//DEVICES
Route::get('/devices/index', function () {
    return Inertia::render('devices/Index');
})->middleware(['auth', 'verified', 'admin'])->name('devices.index');

Route::get('/devices/create', function () {
    return Inertia::render('devices/Form');
})->middleware(['auth', 'verified', 'admin'])->name('devices.create');

Route::get('/devices/{id}/edit', function () {
    return Inertia::render('devices/Form');
})->middleware(['auth', 'verified', 'admin'])->name('devices.edit');

//SERVICES
Route::get('/services/index', function () {
    return Inertia::render('services/Index');
})->middleware(['auth', 'verified', 'admin'])->name('services.index');

Route::get('/services/create', function () {
    return Inertia::render('services/Form');
})->middleware(['auth', 'verified', 'admin'])->name('services.create');

Route::get('/services/{id}/edit', function () {
    return Inertia::render('services/Form');
})->middleware(['auth', 'verified', 'admin'])->name('services.edit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
