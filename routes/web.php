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
        ->whereNumber('id')
        ->group(function () {
            Route::get('/', 'showAll')->name('all');
            Route::get('/{id}', 'view')->name('view');
            Route::get('/{id}/update', 'updatePage')->name('update');
            Route::post('/{id}/update', 'update');
            Route::get('/{id}/delete', 'deletePage')->name('delete');
            Route::post('/{id}/delete', 'delete');
        }
    );
});