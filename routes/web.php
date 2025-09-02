<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Rs\RumahSakitController;
use App\Http\Controllers\Pasien\PasienController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login_post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [IndexController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [IndexController::class, 'getStats'])->name('dashboard.stats');
    Route::get('/dashboard/activities', [IndexController::class, 'getActivities'])->name('dashboard.activities');
    Route::resource('rumah-sakit', RumahSakitController::class);
    Route::resource('pasien', PasienController::class);
    Route::get('/pasien-by-rs/{rumahSakitId}', [PasienController::class, 'getByRumahSakit'])->name('pasien.byRS');
});

Route::get('/test/404', function () {
    abort(404);
});

Route::get('/test/500', function () {
    abort(500);
});

Route::get('/test/403', function () {
    abort(403);
});

Route::get('/test/419', function () {
    abort(419);
});

Route::get('/test/503', function () {
    abort(503);
});
