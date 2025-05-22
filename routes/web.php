<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerkebunanController;


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
    return view('dashboard');
})->name('dashboard');

Route::get('/perkebunan', [PerkebunanController::class, 'index'])->name('perkebunan.index');
Route::get('/perkebunan/create', [PerkebunanController::class, 'create'])->name('perkebunan.create');
Route::post('/perkebunan/store', [PerkebunanController::class, 'store'])->name('perkebunan.store');
Route::post('/perkebunan/upload-csv', [PerkebunanController::class, 'uploadCSV'])->name('perkebunan.uploadCSV');
Route::get('/perkebunan/{id}/edit', [PerkebunanController::class, 'edit'])->name('perkebunan.edit');
Route::put('/perkebunan/{id}', [PerkebunanController::class, 'update'])->name('perkebunan.update');
Route::delete('/perkebunan/{kecamatan_id}/{periode_id}', [PerkebunanController::class, 'destroy'])->name('perkebunan.destroy');

Route::get('/jsdb', function () {
    return view('about');
})->name('about');







Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact',  function () {
    return view('contact');
})->name('contact');

Route::get('/luas-wilayah', function () {
    return view('gambaran_umum.luas_wilayah');
})->name('gambaran_umum.luas_wilayah');

Route::get('/luas-gunung', function () {
    return view('gambaran_umum.nama_dan_ketinggian_gunung');
})->name('gambaran_umum.nama_dan_ketinggian_gunung');

Route::get('/rata_tinggi', function () {
    return view('gambaran_umum.Tinggi_rata_rata');
})->name('gambaran_umum.Tinggi_rata_rata');

Route::get('/luas_daerah', function () {
    return view('gambaran_umum.luas_daerah');
})->name('gambaran_umum.luas_daerah');

Route::get('/luas_daerah2', function () {
    return view('gambaran_umum.luas_daerah2');
})->name('gambaran_umum.luas_daerah2');

Route::get('/luas-wilayah2', function () {
    return view('gambaran_umum.luas_wilayah2');
})->name('gambaran_umum.luas_wilayah2');

Route::get('/Kepadatan_penduduk', function () {
    return view('gambaran_umum.kepadatan_penduduk');
})->name('gambaran_umum.kepadatan_penduduk');

Route::get('Produk_somestik_regional', function () {
    return view('gambaran_umum.produk_somestik_regional');
})->name('gambaran_umum.Produk_somestik_regional');



Route::get('Penggunaan_lahan', function () {
    return view('pertanian_dan_perkebunan.luas_penggunaan_lahan');
})->name('pertanian_dan_perkebunan.luas_penggunaan_lahan');

Route::get('Luas_panen(ton)', function () {
    return view('pertanian_dan_perkebunan.luas_panen_ton');
})->name('pertanian_dan_perkebunan.luas_panen_ton');

Route::get('Luas_panen(hektar)', function () {
    return view('pertanian_dan_perkebunan.luas_panen_hektar');
})->name('pertanian_dan_perkebunan.luas_panen_hektar');

Route::get('tanaman_pangan', function () {
    return view('pertanian_dan_perkebunan.produksi_tanaman_pangan');
})->name('pertanian_dan_perkebunan.produksi_tanaman_pangan');

Route::get('sayuran_kw', function () {
    return view('pertanian_dan_perkebunan.produski_sayuran_kw');
})->name('pertanian_dan_perkebunan.produski_sayuran_kw');

Route::get('sayuran_hektar', function () {
    return view('pertanian_dan_perkebunan.produksi_sayuran_hektar');
})->name('pertanian_dan_perkebunan.produksi_sayuran_hektar');

Route::get('produksi_buahan_kw', function () {
    return view('pertanian_dan_perkebunan.produksi_buahan_kw');
})->name('pertanian_dan_perkebunan.produksi_buahan_kw');

Route::get('tanaman_sayur', function () {
    return view('pertanian_dan_perkebunan.tanaman_sayur');
})->name('pertanian_dan_perkebunan.tanaman_sayur');

Route::get('tanaman_buah_buahan', function () {
    return view('pertanian_dan_perkebunan.tanaman_buah_buahan');
})->name('pertanian_dan_perkebunan.tanaman_buah_buahan');

Route::get('luas_panen_bifarmaka_kg', function () {
    return view('pertanian_dan_perkebunan.luas_panen_biofarmaka_kg');
})->name('pertanian_dan_perkebunan.luas_panen_biofarmaka_kg');

Route::get('luas_panen_bifarmaka_m2', function () {
    return view('pertanian_dan_perkebunan.luas_panen_biofarmaka_m2');
})->name('pertanian_dan_perkebunan.luas_panen_biofarmaka_m2');

Route::get('produksi_tanaman_biofarmaka', function () {
    return view('pertanian_dan_perkebunan.produksi_tanaman_biofarmaka');
})->name('pertanian_dan_perkebunan.produksi_tanaman_biofarmaka');

Route::get('produksi_tanaman_hias', function () {
    return view('pertanian_dan_perkebunan.produksi_tanaman_hias');
})->name('pertanian_dan_perkebunan.produksi_tanaman_hias');

Route::get('produksi_perkebunan', function () {
    return view('pertanian_dan_perkebunan.produksi_perkebunan');
})->name('pertanian_dan_perkebunan.produksi_perkebunan');

Route::get('luas_panen_perkebunan_ha', function () {
    return view('pertanian_dan_perkebunan.luas_panen_perkebunan_ha');
})->name('pertanian_dan_perkebunan.luas_panen_perkebunan_ha');

Route::get('luas_panen_perkebunan_ton', function () {
    return view('pertanian_dan_perkebunan.luas_panen_perkebunan_ton');
})->name('pertanian_dan_perkebunan.luas_panen_perkebunan_ton');

Route::get('jumlah_bangunan_air_ha', function () {
    return view('pertanian_dan_perkebunan.jumlah_bangunan_air_ha');
})->name('pertanian_dan_perkebunan.jumlah_bangunan_air_ha');

Route::get('jumlah_sumber_air', function () {
    return view('pertanian_dan_perkebunan.jumlah_sumber_air');
})->name('pertanian_dan_perkebunan.jumlah_sumber_air');

Route::get('jumlah_embung', function () {
    return view('pertanian_dan_perkebunan.jumlah_embung');
})->name('pertanian_dan_perkebunan.jumlah_embung');

Route::get('luas_lahan_sawah_ha', function () {
    return view('pertanian_dan_perkebunan.luas_lahan_sawah_ha');
})->name('pertanian_dan_perkebunan.luas_lahan_sawah_ha');



Route::get('produksi_non_kayu', function () {
    return view('kehutanan.produksi_non_kayu');
})->name('kehutanan.produksi_non_kayu');

Route::get('produksi_kayu_bulat', function () {
    return view('kehutanan.produksi_kayu_bulat');
})->name('kehutanan.produksi_kayu_bulat');

Route::get('luas_lahan_kehutanan', function () {
    return view('kehutanan.luas_lahan_kehutanan');
})->name('kehutanan.luas_lahan_kehutanan');





Route::get('populasi_hewan_ternak', function () {
    return view('peternakan.populasi_hewan_ternak');
})->name('peternakan.populasi_hewan_ternak');

Route::get('produk_daging', function () {
    return view('peternakan.produk_daging');
})->name('peternakan.produk_daging');

Route::get('populasi_hewan_unggas', function () {
    return view('peternakan.populasi_hewan_unggas');
})->name('peternakan.populasi_hewan_unggas');

Route::get('produksi_susu', function () {
    return view('peternakan.produksi_susu');
})->name('peternakan.produksi_susu');

Route::get('produksi_telur', function () {
    return view('peternakan.produksi_telur');
})->name('peternakan.produksi_telur');




Route::get('profil_perikanan', function () {
    return view('perikanan.profil_perikanan');
})->name('perikanan.profil_perikanan');

Route::get('produksi_perikanan', function () {
    return view('perikanan.produksi_perikanan');
})->name('perikanan.produksi_perikanan');

Route::get('lokasi_usaha_perikanan', function () {
    return view('perikanan.lokasi_usaha_perikanan');
})->name('perikanan.lokasi_usaha_perikanan');

Route::get('produksi_perikanan_budidaya', function () {
    return view('perikanan.produksi_perikanan_budidaya');
})->name('perikanan.produksi_perikanan_budidaya');

Route::get('produksi_perikanan_per_ikan', function () {
    return view('perikanan.produksi_perikanan_per_ikan');
})->name('perikanan.produksi_perikanan_per_ikan');

Route::get('produksi_perikanan_tangkap', function () {
    return view('perikanan.produksi_perikanan_tangkap');
})->name('perikanan.produksi_perikanan_tangkap');




Route::get('perkembangan_pertambangan', function () {
    return view('pertambangan.perkembangan_pertambangan');
})->name('pertambangan.perkembangan_pertambangan');


Route::get('jumlah_seumber_daya_air', function () {
    return view('air.jumlah_sumber_daya_air');
})->name('air.jumlah_sumber_daya_air');
