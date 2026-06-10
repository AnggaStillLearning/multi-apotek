<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PenjualanController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
->middleware(['auth', 'verified'])
->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get(
        '/monitoring/stok-kritis',
        [MonitoringController::class, 'stokKritis']
    )->name('monitoring.stok-kritis');

});
Route::get(
    '/monitoring/kadaluarsa',
    [MonitoringController::class, 'kadaluarsa']
)->name('monitoring.kadaluarsa');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource(
    'penjualans',
    PenjualanController::class
)->middleware('auth');

Route::middleware(['auth'])->group(function () {

    Route::resource('obats', ObatController::class);

});

require __DIR__.'/auth.php';
