<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\SimpananController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('form_login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Route with Middleware

Route::group(['middleware' => ['auth', 'permissions:view-dashboard']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::get('/error/403', [ErrorController::class, 'forbidden'])->name('error.403');
Route::resource('anggota', AnggotaController::class)->except(['show']);
Route::get('anggota/data', [AnggotaController::class, 'getData'])->name('anggota.data');
Route::resource('simpanan', SimpananController::class)->except(['show']);
Route::get('simpanan/data', [SimpananController::class, 'data'])->name('simpanan.data');
