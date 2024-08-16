<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::redirect('/', '/login');
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('/', '/dashboard');
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(ClientController::class)->name('clients.')->group(function () {
        Route::get('/clients', 'showAll')->name('all');
        Route::get('/clients/{client}', 'view')->name('view');
        Route::get('/clients/{client}/update', 'updatePage')->name('update');
        Route::post('/clients/{client}/update', 'update');
        Route::get('/clients/{client}/delete', 'deletePage')->name('delete');
        Route::post('/clients/{client}/delete', 'delete');
    });
});