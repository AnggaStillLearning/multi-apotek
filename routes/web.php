<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ApotekController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController;

Route::get(
    '/',
    [LandingController::class,'index']
)->name('landing');

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->middleware([
    'auth'
])->name('dashboard');

/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:super_admin'
])->group(function () {

    Route::resource(
        'apoteks',
        ApotekController::class
    );

    Route::resource(
        'users',
        UserController::class
    );

});

/*
|--------------------------------------------------------------------------
| ADMIN APOTEK
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:admin_apotek'
])->group(function () {

    Route::resource(
        'obats',
        ObatController::class
    );

    Route::get(
        '/monitoring/stok-kritis',
        [MonitoringController::class, 'stokKritis']
    )->name('monitoring.stok-kritis');

    Route::get(
        '/monitoring/kadaluarsa',
        [MonitoringController::class, 'kadaluarsa']
    )->name('monitoring.kadaluarsa');

});

/*
|--------------------------------------------------------------------------
| ADMIN APOTEK & KASIR
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:admin_apotek,kasir'
])->group(function () {

    Route::resource(
        'penjualans',
        PenjualanController::class
    );

});

Route::get(
    '/obat/info/{nama}',
    [PenjualanController::class, 'getInfoObat']
)->name('obat.info');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});

require __DIR__.'/auth.php';
