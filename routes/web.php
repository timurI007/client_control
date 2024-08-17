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

    Route::controller(ClientController::class)
        ->name('clients.')
        ->prefix('clients')
        ->group(function () {
            Route::get('/', 'showAll')->name('all');
            Route::get('/{client}', 'view')->name('view');
            Route::get('/{client}/update', 'updatePage')->name('update');
            Route::post('/{client}/update', 'update');
            Route::get('/{client}/delete', 'deletePage')->name('delete');
            Route::post('/{client}/delete', 'delete');
        }
    );
});