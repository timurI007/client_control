<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

// AuthController
Route::get('/login', [AuthController::class, 'login_form'])->name('login');
Route::post('/auth', [AuthController::class, 'auth']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class);

    // ClientController
    Route::get('/client/{id}', [ClientController::class, 'view']);
    Route::get('/client/{id}/edit', [ClientController::class, 'edit_page']);
    Route::post('/client/update', [ClientController::class, 'update']);
    Route::post('/client/code', [ClientController::class, 'send_code']);
});