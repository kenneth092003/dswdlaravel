<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\FAII\FAIIDashboardController;
use App\Http\Controllers\Budget\BudgetDashboardController;
use App\Http\Controllers\Cash\CashDashboardController;
use App\Http\Controllers\Procurement\ProcurementDashboardController;
use App\Http\Controllers\Enduser\EnduserDashboardController;

<<<<<<< HEAD
use App\Http\Controllers\EndUser\DashboardController as EndUserDashboardController;
use App\Http\Controllers\EndUser\PurchaseRequestController;
use App\Http\Controllers\EndUser\ProfileController as EndUserProfileController;
use App\Http\Controllers\EndUser\NotificationController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

=======
// -------------------------------------------------------
// Homepage
// -------------------------------------------------------
>>>>>>> 81f4c2acf5b187b13d419a9a9344d0587ebf828c
Route::get('/', function () {
    return view('welcome');
})->name('home');

<<<<<<< HEAD
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

=======
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
>>>>>>> 81f4c2acf5b187b13d419a9a9344d0587ebf828c
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

<<<<<<< HEAD
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
=======
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
>>>>>>> 81f4c2acf5b187b13d419a9a9344d0587ebf828c
