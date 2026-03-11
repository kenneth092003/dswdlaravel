<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\EndUser\DashboardController as EndUserDashboardController;
use App\Http\Controllers\EndUser\PurchaseRequestController;
use App\Http\Controllers\EndUser\ProfileController as EndUserProfileController;
use App\Http\Controllers\EndUser\NotificationController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/about', 'pages.about')->name('about');
Route::view('/features', 'pages.features')->name('features');
Route::view('/support', 'pages.support')->name('support');

/*
|--------------------------------------------------------------------------
| Authenticated Shared Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Superadmin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Roles
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/roles/update', [RoleController::class, 'update'])->name('roles.update');

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });

/*
|--------------------------------------------------------------------------
| Enduser Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Enduser'])
    ->prefix('enduser')
    ->name('enduser.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [EndUserDashboardController::class, 'index'])->name('dashboard');

        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

        // Purchase Requests - Listing / Standard Pages
        Route::get('/requests', [PurchaseRequestController::class, 'index'])->name('requests.index');
        Route::get('/requests/create', [PurchaseRequestController::class, 'create'])->name('requests.create');
        Route::get('/requests/{id}', [PurchaseRequestController::class, 'show'])->name('requests.show');
        Route::get('/requests/{id}/edit', [PurchaseRequestController::class, 'edit'])->name('requests.edit');
        Route::get('/requests/{id}/lifecycle', [PurchaseRequestController::class, 'lifecycle'])->name('requests.lifecycle');

        // Optional standard CRUD
        Route::post('/requests', [PurchaseRequestController::class, 'store'])->name('requests.store');
        Route::put('/requests/{id}', [PurchaseRequestController::class, 'update'])->name('requests.update');

        // Step 1: Basic Info
        Route::post('/requests/basic-info', [PurchaseRequestController::class, 'storeBasicInfo'])->name('requests.store.basic');
        Route::put('/requests/{id}/basic-info', [PurchaseRequestController::class, 'updateBasicInfo'])->name('requests.update.basic');

        // Step 2: Items
        Route::post('/requests/{id}/items', [PurchaseRequestController::class, 'storeItems'])->name('requests.store.items');
        Route::put('/requests/{id}/items', [PurchaseRequestController::class, 'updateItems'])->name('requests.update.items');

        // Step 3: Attachments
        Route::post('/requests/{id}/attachments', [PurchaseRequestController::class, 'storeAttachments'])->name('requests.store.attachments');
        Route::put('/requests/{id}/attachments', [PurchaseRequestController::class, 'updateAttachments'])->name('requests.update.attachments');

        // Draft / Submit / Lifecycle Actions
        Route::patch('/requests/{id}/draft', [PurchaseRequestController::class, 'saveDraft'])->name('requests.draft');
        Route::patch('/requests/{id}/submit', [PurchaseRequestController::class, 'submit'])->name('requests.submit');
        Route::patch('/requests/{id}/cancel', [PurchaseRequestController::class, 'cancel'])->name('requests.cancel');
        Route::patch('/requests/{id}/submit-proposal', [PurchaseRequestController::class, 'submitProposal'])->name('requests.submit.proposal');
        Route::patch('/requests/{id}/submit-signed-pr', [PurchaseRequestController::class, 'submitSignedPR'])->name('requests.submit.signedpr');
        Route::patch('/requests/{id}/submit-rd', [PurchaseRequestController::class, 'submitForRDApproval'])->name('requests.submit.rd');

        // Profile
        Route::get('/profile', [EndUserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [EndUserProfileController::class, 'update'])->name('profile.update');
    });

require __DIR__ . '/auth.php';