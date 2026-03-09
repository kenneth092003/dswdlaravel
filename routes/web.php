<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\FAII\FAIIDashboardController;
use App\Http\Controllers\Budget\BudgetDashboardController;
use App\Http\Controllers\Cash\CashDashboardController;
use App\Http\Controllers\Procurement\ProcurementDashboardController;
use App\Http\Controllers\Enduser\EnduserDashboardController;

// -------------------------------------------------------
// Homepage
// -------------------------------------------------------
Route::get('/', function () {
    return view('welcome');
})->name('home');

// -------------------------------------------------------
// Dashboard — role-based redirect happens inside controller
// -------------------------------------------------------
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// -------------------------------------------------------
// Profile Management
// -------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -------------------------------------------------------
// Super Admin Routes
// -------------------------------------------------------
Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/approve', [UserController::class, 'approve'])->name('admin.users.approve');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::post('/admin/roles/update', [RoleController::class, 'update'])->name('admin.roles.update');

    Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
});

// -------------------------------------------------------
// FAII Routes
// -------------------------------------------------------
Route::middleware(['auth', 'role:FA II'])->group(function () {
    Route::get('/faii/dashboard', [FAIIDashboardController::class, 'index'])->name('faii.dashboard');
});

// -------------------------------------------------------
// Budget Routes
// -------------------------------------------------------
Route::middleware(['auth', 'role:Budget'])->group(function () {
    Route::get('/budget/dashboard', [BudgetDashboardController::class, 'index'])->name('budget.dashboard');
});

// -------------------------------------------------------
// Cash Routes
// -------------------------------------------------------
Route::middleware(['auth', 'role:Cash'])->group(function () {
    Route::get('/cash/dashboard', [CashDashboardController::class, 'index'])->name('cash.dashboard');
});

// -------------------------------------------------------
// Procurement Routes
// -------------------------------------------------------
Route::middleware(['auth', 'role:Procurement'])->group(function () {
    Route::get('/procurement/dashboard', [ProcurementDashboardController::class, 'index'])->name('procurement.dashboard');
});

// -------------------------------------------------------
// Enduser Routes
// -------------------------------------------------------
Route::middleware(['auth', 'role:Enduser'])->group(function () {
    Route::get('/enduser/dashboard', [EnduserDashboardController::class, 'index'])->name('enduser.dashboard');
});

// -------------------------------------------------------
// Public Pages
// -------------------------------------------------------
Route::view('/about', 'pages.about')->name('about');
Route::view('/features', 'pages.features')->name('features');
Route::view('/support', 'pages.support')->name('support');

require __DIR__.'/auth.php';