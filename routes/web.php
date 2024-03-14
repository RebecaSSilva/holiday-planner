<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HolidayPlanController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout Route
Route::post('/logout', function () {
Auth::logout();
return redirect('/login');
})->name('logout');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Home Route
    Route::get('/', function () {
        return view('pages.home');
    });

// Holiday Plan Routes
Route::get('holiday-plans', [HolidayPlanController::class, 'index']);
Route::get('holiday-plans/{id}', [HolidayPlanController::class, 'show']);
Route::post('holiday-plans', [HolidayPlanController::class, 'store']);
Route::post('holiday-plans-edit/{id}', [HolidayPlanController::class, 'update']);
Route::get('holiday-plans/{id}/generate-pdf', [HolidayPlanController::class, 'generatePdf']);
Route::post('holiday-plans/datatable', [HolidayPlanController::class, 'datatable']);
Route::delete('holiday-plans/{id}', [HolidayPlanController::class, 'destroy']);
});

