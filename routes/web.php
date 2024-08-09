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
    Route::get('/dashboard', [DashboardController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::controller(ClientController::class)->group(function () {
        Route::get('/client/{id}', 'view');
        Route::get('/client/{id}/edit', 'editPage');
        Route::post('/client/{id}/edit', 'edit');
        Route::post('/client/{id}/delete', 'delete');
    });
    
    Route::post('/send_code/{method}', [SendCodeConroller::class, 'sendCode']);
});