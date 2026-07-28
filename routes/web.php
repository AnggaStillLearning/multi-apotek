<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{KonversiApiController, GudangApiController, ObatApiController};
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
    PengadaanDetailController,
    PemesananController,
    PemesananDetailController,
    PembelianOnlineController,
    PembelianOfflineController
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

// obats punya bypass isSuperAdmin() di controllernya (lihat ObatController),
// jadi super_admin diizinkan juga di sini — beda dari Monitoring & Pengadaan
// di bawah yang murni pakai auth()->user()->apotek_id tanpa bypass, dan
// akan tampil kosong/rusak kalau diakses super_admin (apotek_id-nya null).
Route::middleware(['auth', 'role:admin_apotek,super_admin'])->group(function () {
    Route::resource('obats', ObatController::class);
});

Route::middleware(['auth', 'role:admin_apotek'])->group(function () {

    // Monitoring
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');

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

    // Pembelian Online — tandai pesanan selesai (barang sudah diambil/dikirim)
    Route::post('/pembelian-online/{pembelian}/selesai', [PembelianOnlineController::class, 'selesai'])
        ->name('pembelian.online.selesai');

    // Info stok/harga obat (dipakai form Penjualan lama)
    Route::get('/obat/info/{nama}', [PenjualanController::class, 'getInfoObat'])->name('obat.info');

    // Pembelian Offline (POS kasir) — kasir input langsung, jenis=offline.
    Route::get('/pembelian-offline', [PembelianOfflineController::class, 'index'])
        ->name('pembelian.offline.index');
    Route::get('/pembelian-offline/create', [PembelianOfflineController::class, 'create'])
        ->name('pembelian.offline.create');
    Route::post('/pembelian-offline', [PembelianOfflineController::class, 'store'])
        ->name('pembelian.offline.store');
    Route::get('/pembelian-offline/{pembelian}', [PembelianOfflineController::class, 'show'])
        ->name('pembelian.offline.show');
});
Route::middleware(['auth', 'role:admin_apotek,super_admin'])->group(function () {
    Route::resource('suppliers', SupplierController::class);
});
/*
|--------------------------------------------------------------------------
| BATCH OBAT ROUTES
|--------------------------------------------------------------------------
| Sebelumnya TANPA middleware sama sekali (celah keamanan + akan fatal
| error kalau diakses guest, karena BatchObatController langsung memanggil
| auth()->user()->isSuperAdmin() tanpa cek null dulu).
*/
Route::middleware(['auth', 'role:admin_apotek,super_admin'])->group(function () {

    Route::prefix('batch')->group(function () {
        Route::get('/{batch}/edit', [BatchObatController::class, 'edit'])->name('batch.edit');
        Route::put('/{batch}', [BatchObatController::class, 'update'])->name('batch.update');
        Route::delete('/{batch}', [BatchObatController::class, 'destroy'])->name('batch.destroy');
    });

    Route::post('/obats/{obat}/batch', [BatchObatController::class, 'store'])->name('batch.store');

});

/*
|--------------------------------------------------------------------------
| KONVERSI OBAT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin_apotek,super_admin'])->group(function () {

    Route::prefix('konversi')->group(function () {
        Route::get('/{konversi}/edit', [KonversiObatController::class, 'edit'])->name('konversi.edit');
        Route::put('/{konversi}', [KonversiObatController::class, 'update'])->name('konversi.update');
        Route::delete('/{konversi}', [KonversiObatController::class, 'destroy'])->name('konversi.destroy');
    });

    Route::post('/obats/{obat}/konversi', [KonversiObatController::class, 'store'])->name('konversi.store');

});

/*
|--------------------------------------------------------------------------
| GUDANG & RUANGAN ROUTES
|--------------------------------------------------------------------------
| Sebelumnya TANPA middleware sama sekali — sama seperti Batch/Konversi
| di atas, GudangController & RuanganController langsung panggil
| auth()->user()->isSuperAdmin() sehingga akses tanpa login = fatal error,
| bukan sekadar celah keamanan.
*/
Route::middleware(['auth', 'role:admin_apotek,super_admin'])->group(function () {

    Route::resource('gudangs', GudangController::class);
    Route::resource('ruangans', RuanganController::class);
    Route::resource('satuans', SatuanController::class);

    Route::post('/gudangs/{gudang}/ruangans', [RuanganController::class, 'storeForGudang'])->name('gudangs.ruangans.store');

    Route::get('/gudangs/{gudang}/ruangans', [BatchObatController::class, 'getRuangan'])->name('gudang.ruangans');

});

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

// Webhook Midtrans (server-to-server, tanpa auth/CSRF — lihat notifikasi()
// di PembelianOnlineController untuk verifikasi signature-nya).
Route::post('/midtrans/notifikasi', [PembelianOnlineController::class, 'notifikasi'])
    ->name('midtrans.notifikasi');

/*
|--------------------------------------------------------------------------
| SHOP ROUTES (AUTHENTICATED - PEMBELI)
|--------------------------------------------------------------------------
| Keranjang (Pemesanan) & checkout/pembayaran (Pembelian online) tersimpan
| di database, bukan session lagi — lihat PemesananController &
| PembelianOnlineController.
*/
Route::middleware(['auth', 'role:pembeli'])->group(function () {

    // Tambah ke keranjang dari halaman katalog/detail produk.
    Route::post('/apotek/{apotek}/keranjang/{obat}', [PemesananController::class, 'store'])
        ->name('pemesanan.items.store');

    // Keranjang
    Route::get('/keranjang', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/keranjang/{pemesanan}', [PemesananController::class, 'show'])->name('pemesanan.show');
    Route::put('/keranjang-item/{detail}', [PemesananDetailController::class, 'update'])
        ->name('pemesanan.items.update');
    Route::delete('/keranjang-item/{detail}', [PemesananDetailController::class, 'destroy'])
        ->name('pemesanan.items.destroy');

    // Checkout keranjang -> Pembelian online
    Route::post('/keranjang/{pemesanan}/checkout', [PembelianOnlineController::class, 'store'])
        ->name('pembelian.online.store');

    // Pesanan saya
    Route::get('/pesanan-saya', [PembelianOnlineController::class, 'index'])->name('pembelian.online.index');
    Route::get('/pesanan-saya/{pembelian}', [PembelianOnlineController::class, 'show'])->name('pembelian.online.show');
    Route::post('/pesanan-saya/{pembelian}/bayar', [PembelianOnlineController::class, 'bayar'])->name('pembelian.online.bayar');
    Route::post('/pesanan-saya/{pembelian}/batal', [PembelianOnlineController::class, 'batal'])->name('pembelian.online.batal');
});

/*
|--------------------------------------------------------------------------
| LAPORAN ROUTES
|--------------------------------------------------------------------------
| Sebelumnya TANPA middleware — ReportController langsung baca
| auth()->user()->role (fatal error kalau guest) dan tidak ada filter
| apotek_id sama sekali untuk role selain admin_apotek/kasir, jadi tanpa
| auth ini bisa jadi kebocoran data penjualan seluruh apotek.
*/
Route::middleware(['auth', 'role:admin_apotek,kasir,super_admin'])->prefix('laporan')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('/export/pdf', [ReportController::class, 'exportPdf'])->name('laporan.export.pdf');
});

/*
|--------------------------------------------------------------------------
| API (dipakai internal oleh form admin_apotek — Pengadaan, Obat, POS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin_apotek,kasir,super_admin'])->prefix('api')->group(function () {

    Route::get(
        '/obats/{obat}/konversi',
        [KonversiApiController::class, 'index']
    )->name('api.obats.konversi');

    Route::get(
        '/gudangs/{gudang}/ruangans',
        [GudangApiController::class, 'ruangans']
    )->name('api.gudangs.ruangans');

    Route::middleware(['role:admin_apotek,kasir'])->group(function () {
        Route::get('/obats/search', [ObatApiController::class, 'search'])
            ->name('api.obats.search');
    });

});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
