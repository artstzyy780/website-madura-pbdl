<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CatatanPenjualanController;
use App\Http\Controllers\LaporanHutangController;
use App\Http\Controllers\ControlAccessController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/login',  [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // Kasir — bisa diakses semua role
    Route::prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/',                        [KasirController::class, 'index'])->name('index');
        Route::get('/cari',                    [KasirController::class, 'cariProduk'])->name('cari');
        Route::get('/drafts',                  [KasirController::class, 'listDraft'])->name('drafts');
        Route::post('/simpan',                 [KasirController::class, 'simpan'])->name('simpan');
        Route::post('/draft',                  [KasirController::class, 'simpanDraft'])->name('draft');
        Route::get('/draft/{transaksi}',       [KasirController::class, 'loadDraft'])->name('draft.load');
        Route::delete('/draft/{transaksi}',    [KasirController::class, 'hapusDraft'])->name('draft.hapus');
        Route::get('/struk/{id}',              [KasirController::class, 'struk'])->name('struk');
    });

    // Laporan Hutang — bisa diakses semua role
    Route::prefix('laporan-hutang')->name('laporan.')->group(function () {
        Route::get('/',                    [LaporanHutangController::class, 'index'])->name('index');
        Route::post('/{transaksi}/lunas',  [LaporanHutangController::class, 'lunaskan'])->name('lunas');
        Route::get('/export/excel',        [LaporanHutangController::class, 'exportExcel'])->name('excel');
        Route::get('/export/pdf',          [LaporanHutangController::class, 'exportPdf'])->name('pdf');
    });

    // Route khusus Admin
    Route::middleware('role:admin')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Data Produk
        Route::prefix('data-produk')->name('produk.')->group(function () {
            Route::get('/',                       [KategoriController::class, 'index'])->name('kategori');
            Route::post('/kategori',              [KategoriController::class, 'store'])->name('kategori.store');
            Route::put('/kategori/{kategori}',    [KategoriController::class, 'update'])->name('kategori.update');
            Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

            Route::get('/{kategori}',             [ProdukController::class, 'index'])->name('index');
            Route::post('/{kategori}',            [ProdukController::class, 'store'])->name('store');
            Route::post('/item/{produk}',         [ProdukController::class, 'update'])->name('update');
            Route::delete('/item/{produk}',       [ProdukController::class, 'destroy'])->name('destroy');
        });

        // Catatan Penjualan
        Route::prefix('catatan-penjualan')->name('catatan.')->group(function () {
            Route::get('/',                    [CatatanPenjualanController::class, 'index'])->name('index');
            Route::post('/{transaksi}/lunas',  [CatatanPenjualanController::class, 'lunaskan'])->name('lunas');
            Route::get('/export/excel',        [CatatanPenjualanController::class, 'exportExcel'])->name('excel');
        });

        // Control Access
        Route::prefix('control-access')->name('access.')->group(function () {
            Route::get('/',                   [ControlAccessController::class, 'index'])->name('index');
            Route::post('/',                  [ControlAccessController::class, 'store'])->name('store');
            Route::put('/{user}',             [ControlAccessController::class, 'update'])->name('update');
            Route::delete('/{user}',          [ControlAccessController::class, 'destroy'])->name('destroy');
            Route::get('/audit-log',          [ControlAccessController::class, 'auditLog'])->name('audit');
            Route::delete('/audit-log/clear', [ControlAccessController::class, 'hapusSemuaLog'])->name('audit.clear');
        });

        // Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/',                   [SettingController::class, 'index'])->name('index');
            Route::post('/profile',           [SettingController::class, 'updateProfile'])->name('profile');
            Route::post('/toko',              [SettingController::class, 'updateToko'])->name('toko');
        });

    }); // end role:admin

});
