<?php

use App\Http\Controllers\BayarHutangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengeluaranKhususController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UangModalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login/store', [LoginController::class, 'store'])->name('store.login');

Route::middleware('auth')->group(
    function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('index/uang/histori', [DashboardController::class, 'histori'])->name('index.historiuang');
        Route::get('rekapan/harian/index', [DashboardController::class, 'rekapan_harian'])->name('index.rekapan_harian');
        Route::get('rekapan/harian/print', [PenjualanController::class, 'print_harian'])->name('print.harian');
        Route::get('rekapan/bulanan/print', [PenjualanController::class, 'print_bulanan'])->name('print.bulanan');
        Route::get('rekapan/bulanan/index', [DashboardController::class, 'rekapan_bulanan'])->name('index.rekapan_bulanan');

        Route::get('/get_pendapatan', [DashboardController::class, 'get_pendapatan'])->name('get_pendapatan');
        Route::get('/get_pengeluaran', [DashboardController::class, 'get_pengeluaran'])->name('get_pengeluaran');
        Route::get('/get_penjualan', [DashboardController::class, 'get_penjualan'])->name('get_penjualan');
        Route::get('/get_pembelian', [DashboardController::class, 'get_pembelian'])->name('get_pembelian');


        Route::get('user/profile', [UserController::class, 'index'])->name('index.user');
        Route::post('profile/store', [UserController::class, 'store'])->name('store.profile');
        Route::post('user/store', [UserController::class, 'kirim'])->name('kirim.user');
        Route::post('change/password', [UserController::class, 'gantiPassword'])->name('change.password');


        Route::get('ice-cream/index', [IceController::class, 'index'])->name('index.ice');
        Route::post('ice-cream/store', [IceController::class, 'store'])->name('ice.store');
        Route::put('ice-cream/{id}/update', [IceController::class, 'update'])->name('ice.update');
        Route::delete('ice-cream/{id}/destroy', [IceController::class, 'destroy'])->name('destroy.produk');
        Route::post('ice-cream/simpan-satuan', [IceController::class, 'storeSatuan'])->name('simpan-satuan');
        Route::post('ice-cream/hapus_terpilih', [IceController::class, 'hapus_terpilih'])->name('ice.hapus_terpilih');



        Route::get('satuan/index', [SatuanController::class, 'index'])->name('index.satuan');
        Route::post('satuan/store', [SatuanController::class, 'store'])->name('store.satuan');
        Route::delete('satuan/{id}/destroy', [SatuanController::class, 'destroy'])->name('destroy.satuan');
        Route::put('satuan/{id}/update', [SatuanController::class, 'update'])->name('update.satuan');
        Route::post('satuan/hapus_terpilih', [SatuanController::class, 'hapus_terpilih'])->name('satuan.hapus_terpilih');


        Route::get('pembelian/index', [PembelianController::class, 'index'])->name('index.pembelian');
        Route::get('pembelian/create', [PembelianController::class, 'create'])->name('create.pembelian');
        Route::post('pembelian/store', [PembelianController::class, 'store'])->name('store.pembelian');
        Route::get('pembelian/laporan', [PembelianController::class, 'laporan_pembelian'])->name('laporan.pembelian');
        Route::get('print-transaksi/{id}/pembelian', [PembelianController::class, 'print_pembelian'])->name('print.pembelian');

        Route::get('print-transaksi/{id}/penjualan', [PenjualanController::class, 'print_penjualan'])->name('print.penjualan');
        Route::get('penjualan/index', [PenjualanController::class, 'index'])->name('index.penjualan');
        Route::get('penjualan/create', [PenjualanController::class, 'create'])->name('create.penjualan');
        Route::post('penjualan/store', [PenjualanController::class, 'store'])->name('store.penjualan');
        Route::get('penjualan/laporan', [PenjualanController::class, 'laporan_penjualan'])->name('laporan.penjualan');

        Route::post('penjualan/hutang', [BayarHutangController::class, 'store'])->name('store.hutang');

        Route::get('uang/modal/index', [UangModalController::class, 'index'])->name('index.uangmodal');
        Route::post('uang/modal/store', [UangModalController::class, 'store'])->name('store.uangmodal');
        Route::delete('uang/{id}/modal/destroy', [UangModalController::class, 'destroy'])->name('destroy.uangmodal');
        Route::post('uang/modal/hapus/terpilih', [UangModalController::class, 'hapus_terpilih'])->name('hapus_terpilih.uangmodal');


        Route::get('pengeluaran/khusus/index', [PengeluaranKhususController::class, 'index'])->name('index.pengeluarankhusus');
        Route::post('pengeluaran/khusus/store', [PengeluaranKhususController::class, 'store'])->name('store.pengeluarankhusus');
    }
);
