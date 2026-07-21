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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BatchObatController;
use App\Http\Controllers\KonversiObatController;

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

Route::get(
    '/laporan',
    [ReportController::class, 'index']
)->name('laporan.index');

Route::get(
    '/laporan/export/pdf',
    [ReportController::class, 'exportPdf']
)->name('laporan.export.pdf');

/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/

Route::resource('ruangans', RuanganController::class);
Route::resource('satuans', SatuanController::class);

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
Route::get(
    '/gudangs/{gudang}/ruangans',
    [BatchObatController::class,'getRuangan']
)->name('gudang.ruangans');

Route::post(
    '/obats/{obat}/batch',
    [BatchObatController::class, 'store']
)->name('batch.store');

Route::put(
    '/batch/{batch}',
    [BatchObatController::class, 'update']
)->name('batch.update');

Route::get(
    '/batch/{batch}/edit',
    [BatchObatController::class,'edit']
)->name('batch.edit');

Route::put(
    '/batch/{batch}',
    [BatchObatController::class,'update']
)->name('batch.update');

Route::delete(
    '/batch/{batch}',
    [BatchObatController::class,'destroy']
)->name('batch.destroy');

Route::delete(
    '/batch/{batch}',
    [BatchObatController::class, 'destroy']
)->name('batch.destroy');


Route::middleware([
    'auth',
    'role:admin_apotek,kasir'
])->group(function () {

    Route::resource(
        'penjualans',
        PenjualanController::class
    );

});
Route::resource('gudangs', GudangController::class);

Route::get(
    '/obat/info/{nama}',
    [PenjualanController::class, 'getInfoObat']
)->name('obat.info');

Route::post(
    '/obats/{obat}/konversi',
    [KonversiObatController::class, 'store']
)->name('konversi.store');

Route::get(
    '/konversi/{konversi}/edit',
    [KonversiObatController::class, 'edit']
)->name('konversi.edit');

Route::put(
    '/konversi/{konversi}',
    [KonversiObatController::class, 'update']
)->name('konversi.update');

Route::delete(
    '/konversi/{konversi}',
    [KonversiObatController::class, 'destroy']
)->name('konversi.destroy');

/*
|--------------------------------------------------------------------------
| SHOP
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ShopController;

Route::get(
    '/produk',
    [ShopController::class, 'index']
)->name('shop.index');

Route::get(
    '/produk/{obat}',
    [ShopController::class, 'show']
)->name('shop.show');

/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:pembeli'
])->group(function () {

    Route::get(
        '/cart',
        [ShopController::class, 'cart']
    )->name('cart.index');

    Route::post(
        '/cart/add/{obat}',
        [ShopController::class, 'addToCart']
    )->name('cart.add');

    Route::post(
        '/cart/update/{id}',
        [ShopController::class, 'updateCart']
    )->name('cart.update');

    Route::delete(
        '/cart/remove/{id}',
        [ShopController::class, 'removeCart']
    )->name('cart.remove');

});

Route::get(
    '/checkout',
    [ShopController::class, 'checkout']
)->name('checkout.index');

Route::post(
    '/checkout',
    [ShopController::class, 'storeCheckout']
)->name('checkout.store');

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
