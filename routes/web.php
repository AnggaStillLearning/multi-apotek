<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{KonversiApiController, GudangApiController};
use App\Http\Controllers\{
    ProfileController,
    DashboardController,
    ObatController,
    MonitoringController,
    PenjualanController,
    ApotekController,
    UserController,
    LandingController,
    ReportController,
    GudangController,
    RuanganController,
    SatuanController,
    BatchObatController,
    KonversiObatController,
    ShopController,
    SupplierController,
    PengadaanController,
    PengadaanDetailController
};

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| SUPER ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('apoteks', ApotekController::class);
    Route::resource('users', UserController::class);
});

/*
|--------------------------------------------------------------------------
| ADMIN APOTEK ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin_apotek'])->group(function () {
    Route::resource('obats', ObatController::class);

    // Monitoring
    Route::get('/monitoring/stok-kritis', [MonitoringController::class, 'stokKritis'])->name('monitoring.stok-kritis');
    Route::get('/monitoring/kadaluarsa', [MonitoringController::class, 'kadaluarsa'])->name('monitoring.kadaluarsa');

    // Pengadaan
    Route::resource('pengadaans', PengadaanController::class);

    Route::post('/pengadaans/{pengadaan}/selesaikan', [PengadaanController::class, 'selesaikan'])
        ->name('pengadaans.selesaikan');

    Route::post('/pengadaans/{pengadaan}/items', [PengadaanDetailController::class, 'store'])
        ->name('pengadaans.items.store');

    Route::put('/pengadaan-items/{detail}', [PengadaanDetailController::class, 'update'])
        ->name('pengadaans.items.update');

    Route::delete('/pengadaan-items/{detail}', [PengadaanDetailController::class, 'destroy'])
        ->name('pengadaans.items.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN APOTEK & KASIR ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin_apotek,kasir'])->group(function () {

    Route::resource('penjualans', PenjualanController::class);

    Route::post('/penjualans/cart', [PenjualanController::class, 'addToCart'])
        ->name('penjualans.cart');

    Route::put('/penjualans/cart/{index}', [PenjualanController::class, 'updateCart'])
        ->name('penjualans.cart.update');

    Route::delete('/penjualans/cart/{index}', [PenjualanController::class, 'removeCart'])
        ->name('penjualans.cart.remove');

    Route::post('/penjualans/checkout', [PenjualanController::class, 'checkout'])
        ->name('penjualans.checkout');
});
Route::resource('suppliers', SupplierController::class);
/*
|--------------------------------------------------------------------------
| BATCH OBAT ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('batch')->group(function () {
    Route::get('/{batch}/edit', [BatchObatController::class, 'edit'])->name('batch.edit');
    Route::put('/{batch}', [BatchObatController::class, 'update'])->name('batch.update');
    Route::delete('/{batch}', [BatchObatController::class, 'destroy'])->name('batch.destroy');
});

Route::post('/obats/{obat}/batch', [BatchObatController::class, 'store'])->name('batch.store');

/*
|--------------------------------------------------------------------------
| KONVERSI OBAT ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('konversi')->group(function () {
    Route::get('/{konversi}/edit', [KonversiObatController::class, 'edit'])->name('konversi.edit');
    Route::put('/{konversi}', [KonversiObatController::class, 'update'])->name('konversi.update');
    Route::delete('/{konversi}', [KonversiObatController::class, 'destroy'])->name('konversi.destroy');
});

Route::post('/obats/{obat}/konversi', [KonversiObatController::class, 'store'])->name('konversi.store');

/*
|--------------------------------------------------------------------------
| GUDANG & RUANGAN ROUTES
|--------------------------------------------------------------------------
*/
Route::resource('gudangs', GudangController::class);
Route::resource('ruangans', RuanganController::class);
Route::resource('satuans', SatuanController::class);

Route::post('/gudangs/{gudang}/ruangans', [RuanganController::class, 'storeForGudang'])->name('gudangs.ruangans.store');

Route::get('/gudangs/{gudang}/ruangans', [BatchObatController::class, 'getRuangan'])->name('gudang.ruangans');

/*
|--------------------------------------------------------------------------
| SHOP ROUTES (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/apotek', [ShopController::class, 'apoteks'])
    ->name('shop.apoteks');

Route::get('/apotek/{apotek}', [ShopController::class, 'katalog'])
    ->name('shop.katalog');

Route::get('/apotek/{apotek}/produk/{obat}', [ShopController::class, 'show'])
    ->name('shop.show');

/*
|--------------------------------------------------------------------------
| SHOP ROUTES (AUTHENTICATED - PEMBELI)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pembeli'])->prefix('cart')->group(function () {
    Route::get('/', [ShopController::class, 'cart'])->name('cart.index');
    Route::post('/add/{obat}', [ShopController::class, 'addToCart'])->name('cart.add');
    Route::post('/update/{id}', [ShopController::class, 'updateCart'])->name('cart.update');
    Route::delete('/remove/{id}', [ShopController::class, 'removeCart'])->name('cart.remove');
});

Route::prefix('checkout')->group(function () {
    Route::get('/', [ShopController::class, 'checkout'])->name('checkout.index');
    Route::post('/', [ShopController::class, 'storeCheckout'])->name('checkout.store');
});

/*
|--------------------------------------------------------------------------
| LAPORAN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('laporan')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('/export/pdf', [ReportController::class, 'exportPdf'])->name('laporan.export.pdf');
});

/*
|--------------------------------------------------------------------------
| OBAT INFO (API-like)
|--------------------------------------------------------------------------
*/
Route::get('/obat/info/{nama}', [PenjualanController::class, 'getInfoObat'])->name('obat.info');
Route::prefix('api')->group(function () {

    Route::get(
        '/obats/{obat}/konversi',
        [KonversiApiController::class, 'index']
    )->name('api.obats.konversi');

    Route::get(
        '/gudangs/{gudang}/ruangans',
        [GudangApiController::class, 'ruangans']
    )->name('api.gudangs.ruangans');

});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
