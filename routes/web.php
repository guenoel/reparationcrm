<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard_admin', function () {
    return Inertia::render('Dashboard_Admin');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard_admin');

Route::get('/dashboard_worker', function () {
    return Inertia::render('Dashboard_Worker');
})->middleware(['auth', 'verified', 'worker'])->name('dashboard_worker');

Route::get('/dashboard_customer', function () {
    return Inertia::render('Dashboard_Customer');
})->middleware(['auth', 'verified', 'customer'])->name('dashboard_customer');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
