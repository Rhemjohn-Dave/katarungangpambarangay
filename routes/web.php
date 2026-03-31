<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Auth::routes(['register' => false]);

/*
|--------------------------------------------------------------------------
| Root Redirect
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard (role-based view handled in controller)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Case Management (all authenticated users)
    Route::resource('cases', CaseController::class);

    // PDF viewer/download route — streams file through Laravel to avoid URL path issues
    Route::get('cases/{case}/pdf', [CaseController::class, 'pdf'])->name('cases.pdf');

    // User Management (Admin only — enforced via middleware in controller)
    Route::resource('users', UserController::class);
});
