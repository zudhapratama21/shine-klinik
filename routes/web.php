<?php

use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\KategoriOperasionalController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\KategoriTreatmentController;
use App\Http\Controllers\LaporanAdmController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\OperasionalController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RegistrasiPasienController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\TreatmentPasienController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Authenticate;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/listproduct', [IndexController::class, 'product'])->name('index.product');
Route::get('/listtreatment/{slug}', [IndexController::class, 'treatment'])->name('index.treatment');

Route::middleware(Authenticate::class)->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/grafikpenjualan', [App\Http\Controllers\HomeController::class, 'grafikPenjualan'])->name('home.grafikpenjualan');
    Route::post('/grafiktreatment', [App\Http\Controllers\HomeController::class, 'grafikTreatment'])->name('home.grafiktreatment');
    Route::post('/grafikpembelian', [App\Http\Controllers\HomeController::class, 'grafikPembelian'])->name('home.grafikpembelian');
    Route::post('/grafikoperasional', [App\Http\Controllers\HomeController::class, 'grafikOperasional'])->name('home.grafikoperasional');
    
    Route::get('dokter/laporan', [DokterController::class, 'laporan'])->name('dokter.laporan');
    Route::get('pasien/laporan', [PasienController::class, 'laporan'])->name('pasien.laporan');
    Route::resource('user', UserController::class);
    Route::resource('profil', ProfilController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('product', ProductController::class);
    Route::get('product/{id}/historyproduct', [ProductController::class, 'historyProduct'])->name('product.historyproduct');

    Route::resource('supplier', SupplierController::class);
    Route::resource('treatment', TreatmentController::class);
    Route::resource('kategoriproduk', KategoriProdukController::class);
    Route::resource('kategoritreatment', KategoriTreatmentController::class);
    // Route::resource('administrasi', AdministrasiController::class);
    Route::get('laporan/administrasi', [LaporanAdmController::class, 'index'])->name('laporan.adm');

    // ROUTE UNTUK TRANSAKSI PEMBELIAN 
    Route::post('pembelian/saveproduct', [PembelianController::class, 'saveProduct'])->name('pembelian.saveproduct');
    Route::get('pembelian/dataproduct', [PembelianController::class, 'dataProduct'])->name('pembelian.dataproduct');
    Route::post('pembelian/hapusitem', [PembelianController::class, 'hapusItem'])->name('pembelian.hapusitem');
    Route::post('pembelian/hitungtotal', [PembelianController::class, 'hitungTotal'])->name('pembelian.hitungtotal');

    Route::post('pembelian/simpan', [PembelianController::class, 'simpan'])->name('pembelian.simpan');

    Route::resource('pembelian', PembelianController::class);
    Route::POST('pembelian/dataproductedit', [PembelianController::class, 'dataProductEdit'])->name('pembelian.dataproductedit');
    Route::POST('pembelian/hitungtotaledit', [PembelianController::class, 'hitungTotalEdit'])->name('pembelian.hitungtotaledit');

    Route::POST('pembelian/hapusitemedit', [PembelianController::class, 'hapusItemEdit'])->name('pembelian.hapusitemedit');
    Route::POST('pembelian/saveproductedit', [PembelianController::class, 'saveProductEdit'])->name('pembelian.saveproductedit');
    Route::POST('pembelian/simpanedit', [PembelianController::class, 'simpanEdit'])->name('pembelian.simpanedit');

    // ===============================================================


    // ==============================  PENJUALAN ===================================

    Route::post('penjualan/saveproduct', [PenjualanController::class, 'saveProduct'])->name('penjualan.saveproduct');
    Route::get('penjualan/dataproduct', [PenjualanController::class, 'dataProduct'])->name('penjualan.dataproduct');
    Route::post('penjualan/hapusitem', [PenjualanController::class, 'hapusItem'])->name('penjualan.hapusitem');
    Route::post('penjualan/hitungtotal', [PenjualanController::class, 'hitungTotal'])->name('penjualan.hitungtotal');

    Route::post('penjualan/simpan', [PenjualanController::class, 'simpan'])->name('penjualan.simpan');

    Route::POST('penjualan/dataproductedit', [PenjualanController::class, 'dataProductEdit'])->name('penjualan.dataproductedit');
    Route::POST('penjualan/hitungtotaledit', [PenjualanController::class, 'hitungTotalEdit'])->name('penjualan.hitungtotaledit');

    Route::POST('penjualan/hapusitemedit', [PenjualanController::class, 'hapusItemEdit'])->name('penjualan.hapusitemedit');
    Route::POST('penjualan/saveproductedit', [PenjualanController::class, 'saveProductEdit'])->name('penjualan.saveproductedit');
    Route::POST('penjualan/simpanedit', [PenjualanController::class, 'simpanEdit'])->name('penjualan.simpanedit');

    Route::GET('penjualan/{id}/print', [PenjualanController::class, 'print'])->name('penjualan.print');

    Route::resource('penjualan', PenjualanController::class);

    // ============================= END OF PENJUALAN ==============================


    // =======================  TREATMENT PASIEN =================================

    Route::post('treatmentpasien/savetreatment', [TreatmentPasienController::class, 'saveTreatment'])->name('treatmentpasien.savetreatment');
    Route::get('treatmentpasien/datatreatment', [TreatmentPasienController::class, 'dataTreatment'])->name('treatmentpasien.datatreatment');
    Route::post('treatmentpasien/hapusitem', [TreatmentPasienController::class, 'hapusItem'])->name('treatmentpasien.hapusitem');
    Route::post('treatmentpasien/hitungtotal', [TreatmentPasienController::class, 'hitungTotal'])->name('treatmentpasien.hitungtotal');

    Route::post('treatmentpasien/simpan', [TreatmentPasienController::class, 'simpan'])->name('treatmentpasien.simpan');

    Route::POST('treatmentpasien/datatreatmentedit', [TreatmentPasienController::class, 'dataTreatmentEdit'])->name('treatmentpasien.datatreatmentedit');
    Route::POST('treatmentpasien/hitungtotaledit', [TreatmentPasienController::class, 'hitungTotalEdit'])->name('treatmentpasien.hitungtotaledit');

    Route::POST('treatmentpasien/hapusitemedit', [TreatmentPasienController::class, 'hapusItemEdit'])->name('treatmentpasien.hapusitemedit');
    Route::POST('treatmentpasien/savetreatmentedit', [TreatmentPasienController::class, 'saveTreatmentEdit'])->name('treatmentpasien.savetreatmentedit');
    Route::POST('treatmentpasien/simpanedit', [TreatmentPasienController::class, 'simpanEdit'])->name('treatmentpasien.simpanedit');

    Route::get('treatmentpasien/{id}/inputproduk', [TreatmentPasienController::class, 'inputProduk'])->name('treatmentpasien.inputproduk');

    Route::post('treatmentpasien/{id}/tambahproduk', [TreatmentPasienController::class, 'tambahProduk'])->name('treatmentpasien.tambahproduk');
    Route::delete('treatmentpasien/{id}/deleteproduk', [TreatmentPasienController::class, 'deleteProduk'])->name('treatmentpasien.deleteproduk');

    Route::resource('treatmentpasien', TreatmentPasienController::class);

    Route::GET('treatmentpasien/{id}/print', [TreatmentPasienController::class, 'print'])->name('treatmentpasien.print');

    // ========================== END OF TREATMENT ================================

    // ========================== DATA OPERASIONAL =================================
    Route::resource('kategorioperasional', KategoriOperasionalController::class);
    Route::resource('operasional', OperasionalController::class);
    // ========================== END OF OPERASIONAL ===============================




});

//membuat route logout
Route::get('logout', function () {
    Auth::logout();
    return redirect('/login');
});

Auth::routes([
    //menghilangkan fungsi register di halaman login
    'register' => false
]);

