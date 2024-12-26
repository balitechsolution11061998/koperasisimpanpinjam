<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\TransactionController;
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

Route::get('/', function () {
    return view('welcome'); // Adjust the view path as necessary
})->name('welcome');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('form_login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Route with Middleware

Route::group(['middleware' => ['auth', 'permissions:view_dashboard']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Member Management Routes
Route::group(['middleware' => ['auth', 'permissions:view-anggota']], function () {
    Route::resource('anggota', AnggotaController::class)->except(['show']);
    Route::get('anggota/data', [AnggotaController::class, 'getData'])->name('anggota.data');
});

// Savings Management Routes
Route::group(['middleware' => ['auth', 'permissions:view-simpanan']], function () {
    Route::resource('simpanan', SimpananController::class)->except(['show']);
    Route::get('simpanan/data', [SimpananController::class, 'data'])->name('simpanan.data');
});

// Loan Management Routes
Route::group(['middleware' => ['auth', 'permissions:view-loans']], function () {
    Route::resource('loans', LoanController::class)->except(['show']);
    Route::get('loans/data', [LoanController::class, 'data'])->name('loans.data');
});

// Transaction Management Routes
Route::group(['middleware' => ['auth', 'permissions:view-transactions']], function () {
    Route::resource('transactions', TransactionController::class)->except(['show']);
    Route::get('transactions/data', [TransactionController::class, 'data'])->name('transactions.data');
});

// Report Management Routes
Route::group(['middleware' => ['auth', 'permissions:view-reports']], function () {
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
});

// Settings Management Routes
Route::group(['middleware' => ['auth', 'permissions:manage-settings']], function () {
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/update', [SettingsController::class, 'update'])->name('settings.update');
});

// Notification Routes
Route::group(['middleware' => ['auth', 'permissions:send-notifications']], function () {
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/send', [NotificationController::class, 'send'])->name('notifications.send');
});

// Audit Log Routes
Route::group(['middleware' => ['auth', 'permissions:view-audit-logs']], function () {
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
});



Route::get('/error/403', [ErrorController::class, 'forbidden'])->name('error.403');
