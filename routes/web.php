<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;

// Homepage (welcome.blade.php)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard (important: add name 'dashboard')
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Authenticated routes (profile management)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Super Admin routes
Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    // Manage Users
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/approve', [UserController::class, 'approve'])->name('admin.users.approve');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Manage Roles
    Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');

    // System Settings
    Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');

    // Reports
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
});

// Public pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/features', 'pages.features')->name('features');
Route::view('/support', 'pages.support')->name('support');

Route::get('/admin/roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('admin.roles.index');
Route::post('/admin/roles/update', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('admin.roles.update');
require __DIR__.'/auth.php';