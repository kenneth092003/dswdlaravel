<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AttendanceController;

use App\Http\Controllers\FAII\FAIIDashboardController;
use App\Http\Controllers\FAII\FAIIRequestController;

use App\Http\Controllers\Budget\BudgetDashboardController;
use App\Http\Controllers\Budget\BudgetRequestController;

use App\Http\Controllers\Cash\CashDashboardController;
use App\Http\Controllers\Cash\CashRequestController;

use App\Http\Controllers\Procurement\ProcurementDashboardController;
use App\Http\Controllers\Procurement\ProcurementRequestController;

use App\Http\Controllers\EndUser\EnduserDashboardController;
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
| Shared Authenticated Routes
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
| Super Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Super Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        // ✅ Attendance
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

        Route::get('/profile', [EndUserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [EndUserProfileController::class, 'update'])->name('profile.update');
    });

/*
|--------------------------------------------------------------------------
| End User
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:End User'])
    ->prefix('enduser')
    ->name('enduser.')
    ->group(function () {
        Route::get('/dashboard', [EnduserDashboardController::class, 'index'])->name('dashboard');

        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/live', [NotificationController::class, 'live'])->name('notifications.live');
        Route::patch('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readall');

        Route::get('/requests', [PurchaseRequestController::class, 'index'])->name('requests.index');
        Route::get('/requests/create', [PurchaseRequestController::class, 'create'])->name('requests.create');
        Route::get('/requests/{id}', [PurchaseRequestController::class, 'show'])->name('requests.show');
        Route::get('/requests/{id}/edit', [PurchaseRequestController::class, 'edit'])->name('requests.edit');
        Route::get('/requests/{id}/lifecycle', [PurchaseRequestController::class, 'lifecycle'])->name('requests.lifecycle');

        Route::post('/requests/basic-info', [PurchaseRequestController::class, 'storeBasicInfo'])->name('requests.store.basic');
        Route::put('/requests/{id}/basic-info', [PurchaseRequestController::class, 'updateBasicInfo'])->name('requests.update.basic');

        Route::post('/requests/{id}/items', [PurchaseRequestController::class, 'storeItems'])->name('requests.store.items');
        Route::put('/requests/{id}/items', [PurchaseRequestController::class, 'updateItems'])->name('requests.update.items');

        Route::post('/requests/{id}/attachments', [PurchaseRequestController::class, 'storeAttachments'])->name('requests.store.attachments');
        Route::put('/requests/{id}/attachments', [PurchaseRequestController::class, 'updateAttachments'])->name('requests.update.attachments');

        Route::patch('/requests/{id}/draft', [PurchaseRequestController::class, 'saveDraft'])->name('requests.draft');

        Route::patch('/requests/{id}/submit', [PurchaseRequestController::class, 'submitProposal'])->name('requests.submit');

        Route::get('/profile', [EndUserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [EndUserProfileController::class, 'update'])->name('profile.update');

        Route::patch('/enduser/requests/{id}/submit-signedpr', [PurchaseRequestController::class, 'submitSignedPr'])
            ->name('enduser.requests.submit.signedpr');
        Route::patch('/requests/{id}/submit-procurement', [PurchaseRequestController::class, 'submitToProcurement'])
            ->name('requests.submit.procurement');
    });

/*
|--------------------------------------------------------------------------
| Procurement
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Procurement'])
    ->prefix('procurement')
    ->name('procurement.')
    ->group(function () {
        Route::get('/dashboard', [ProcurementDashboardController::class, 'index'])->name('dashboard');
        Route::get('/step1', [ProcurementDashboardController::class, 'index'])->name('step1');
        Route::get('/step2', [ProcurementDashboardController::class, 'step2'])->name('step2');
        Route::get('/step3', [ProcurementDashboardController::class, 'step3'])->name('step3');

        Route::get('/requests/{id}', [ProcurementDashboardController::class, 'show'])->name('requests.show');
        Route::post('/requests/{id}/approve', [ProcurementDashboardController::class, 'approve'])->name('requests.approve');
        Route::post('/requests/{id}/reject', [ProcurementDashboardController::class, 'reject'])->name('requests.reject');

        Route::patch('/requests/{id}/receive', [ProcurementRequestController::class, 'receive'])->name('requests.receive');
        Route::patch('/requests/{id}/return', [ProcurementRequestController::class, 'returnToEndUser'])->name('requests.return');
        Route::patch('/requests/{id}/forward-fa2', [ProcurementRequestController::class, 'forwardToFAII'])->name('requests.forward.fa2');
    });

/*
|--------------------------------------------------------------------------
| FA II
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:FA II'])
    ->prefix('faii')
    ->name('faii.')
    ->group(function () {
        Route::get('/dashboard', [FAIIDashboardController::class, 'index'])->name('dashboard');

        Route::get('/requests', [FAIIRequestController::class, 'index'])->name('requests.index');
        Route::get('/requests/{id}', [FAIIRequestController::class, 'show'])->name('requests.show');

        Route::patch('/requests/{id}/review', [FAIIRequestController::class, 'review'])->name('requests.review');
        Route::patch('/requests/{id}/return', [FAIIRequestController::class, 'returnToProcurement'])->name('requests.return');
        Route::patch('/requests/{id}/reject', [FAIIRequestController::class, 'reject'])->name('requests.reject');
        Route::patch('/requests/{id}/forward-budget', [FAIIRequestController::class, 'forwardToBudget'])->name('requests.forward.budget');
    });

/*
|--------------------------------------------------------------------------
| Budget
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Budget'])
    ->prefix('budget')
    ->name('budget.')
    ->group(function () {
        Route::get('/dashboard', [BudgetDashboardController::class, 'index'])->name('dashboard');

        Route::get('/requests', [BudgetRequestController::class, 'index'])->name('requests.index');
        Route::get('/requests/{id}', [BudgetRequestController::class, 'show'])->name('requests.show');

        Route::patch('/requests/{id}/clear', [BudgetRequestController::class, 'clear'])->name('requests.clear');
        Route::patch('/requests/{id}/return', [BudgetRequestController::class, 'returnToFAII'])->name('requests.return');
        Route::patch('/requests/{id}/forward-cash', [BudgetRequestController::class, 'forwardToCash'])->name('requests.forward.cash');
    });

/*
|--------------------------------------------------------------------------
| Cash
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Cash'])
    ->prefix('cash')
    ->name('cash.')
    ->group(function () {
        Route::get('/dashboard', [CashDashboardController::class, 'index'])->name('dashboard');

        Route::get('/requests', [CashRequestController::class, 'index'])->name('requests.index');
        Route::get('/requests/{id}', [CashRequestController::class, 'show'])->name('requests.show');

        Route::patch('/requests/{id}/approve', [CashRequestController::class, 'approve'])->name('requests.approve');
        Route::patch('/requests/{id}/return', [CashRequestController::class, 'returnToBudget'])->name('requests.return');
        Route::patch('/requests/{id}/reject', [CashRequestController::class, 'reject'])->name('requests.reject');
    });

require __DIR__ . '/auth.php';