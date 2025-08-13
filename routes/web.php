<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\MasterDataController; 
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

Route::get('/generator', [GeneratorController::class, 'showGeneratorForm'])->name('generator.show');
Route::post('/generator', [GeneratorController::class, 'generate'])->name('generator.generate');
Route::get('/generator/get-columns/{table}', [GeneratorController::class, 'getColumns'])->name('generator.getColumns');
    

// Rute untuk Editor Data Master (BARU)
Route::prefix('master-data')->name('master-data.')->group(function () {
    Route::get('/', [MasterDataController::class, 'index'])->name('index');
    // Rute API untuk interaksi dinamis
    Route::get('/fetch/{table}', [MasterDataController::class, 'fetchData'])->name('fetch');
    Route::post('/store/{table}', [MasterDataController::class, 'store'])->name('store');
    Route::put('/update/{table}/{id}', [MasterDataController::class, 'update'])->name('update');
    Route::delete('/destroy/{table}/{id}', [MasterDataController::class, 'destroy'])->name('destroy');
});


Route::get('/perkebunan', [PerkebunanController::class, 'index'])->name('perkebunan.index');
Route::get('/perkebunan/create', [PerkebunanController::class, 'create'])->name('perkebunan.create');
Route::post('/perkebunan/store', [PerkebunanController::class, 'store'])->name('perkebunan.store');
Route::post('/perkebunan/upload-csv', [PerkebunanController::class, 'uploadCSV'])->name('perkebunan.uploadCSV');
Route::get('/perkebunan/{id}/edit', [PerkebunanController::class, 'edit'])->name('perkebunan.edit');
Route::put('/perkebunan/{id}', [PerkebunanController::class, 'update'])->name('perkebunan.update');
Route::delete('/perkebunan/{kecamatan_id}/{periode_id}', [PerkebunanController::class, 'destroy'])->name('perkebunan.destroy');



Route::get('/1', function () {
    return view('auth.login');
})->name('auth.login');
