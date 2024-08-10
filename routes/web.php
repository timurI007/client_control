<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SendCodeConroller;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::redirect('/', '/login');
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('/', '/dashboard');
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::controller(ClientController::class)->group(function () {
        Route::get('/clients', 'show')->name('clients');
        Route::get('/clients/{id}/edit', 'editPage');
        Route::post('/clients/{id}/edit', 'edit');
        Route::post('/clients/{id}/delete', 'delete');
    });
    
    Route::post('/send_code/{method}', [SendCodeConroller::class, 'sendCode']);
});