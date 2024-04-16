<?php

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

Route::get('/add', [\App\Http\Controllers\HomeController::class, 'add'])->name('add');
Route::post('/add', [\App\Http\Controllers\HomeController::class, 'save'])->name('save');
Route::get('/addmatakuliah', [\App\Http\Controllers\ProdiController::class, 'addmatakuliah'])->name('addmatakuliah');
Route::post('/addmatakuliah', [\App\Http\Controllers\ProdiController::class, 'savematakuliah'])->name('savematakuliah');
Route::get('/addmatakuliahadmin', [\App\Http\Controllers\AdminController::class, 'addmatakuliahadmin'])->name('addmatakuliahadmin');
Route::post('/addmatakuliahadmin', [\App\Http\Controllers\AdminController::class, 'savematakuliahadmin'])->name('savematakuliahadmin');

Auth::routes();

Route::get('datamahasiswadankandidat', function () { return view('layouts\admin\datamahasiswadankandidat'); })->middleware('checkRole:admin');
Route::get('datamatakuliah', function () { return view('layouts\prodi\datamatakuliah'); })->middleware('checkRole:prodi');
Route::get('datamatakuliahadmin', function () { return view('layouts\admin\datamatakuliahadmin'); })->middleware('checkRole:admin');
Route::get('datamahasiswa', function () { return view('layouts\prodi\datamahasiswa'); })->middleware('checkRole:prodi');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/datamahasiswa', [App\Http\Controllers\MahasiswaController::class, 'index'])->name('datamahasiswa');
Route::get('/datamahasiswadankandidat', [App\Http\Controllers\AdminController::class, 'index'])->name('datamahasiswadankandidat');
Route::get('/datamatakuliah', [App\Http\Controllers\ProdiController::class, 'index'])->name('datamatakuliah');
Route::get('/datamatakuliahadmin', [App\Http\Controllers\AdminController::class, 'index1'])->name('datamatakuliahadmin');

Route::get('admin', function () { return view('layouts\admin\admin'); })->middleware('checkRole:admin');
Route::get('prodi', function () { return view('layouts\prodi\prodi'); })->middleware(['checkRole:prodi,admin']);
Route::get('mahasiswa', function () { return view('layouts\mahasiswa\mahasiswa'); })->middleware(['checkRole:mahasiswa,admin']);

Route::delete('hapus/{id}', [App\Http\Controllers\AdminController::class, 'hapus'])->name('hapus');
Route::delete('hapusmatakuliah/{kode_mk}', [App\Http\Controllers\ProdiController::class, 'hapusmatakuliah'])->name('hapusmatakuliah');
Route::delete('hapusmatakuliahadmin/{kode_mk}', [App\Http\Controllers\AdminController::class, 'hapusmatakuliahadmin'])->name('hapusmatakuliahadmin');

Route::get('periode', [App\Http\Controllers\ProdiController::class, 'periode'])->middleware(['checkRole:prodi,admin']);
Route::get('addpolling', [App\Http\Controllers\ProdiController::class, 'addpolling'])->middleware(['checkRole:prodi,admin'])->name('addpolling');
Route::post('addpolling', [App\Http\Controllers\ProdiController::class, 'addpollingproses'])->middleware(['checkRole:prodi,admin'])->name('addpollingproses');

Route::get('polling', [App\Http\Controllers\MahasiswaController::class, 'polling'])->middleware(['checkRole:admin,mahasiswa']);
Route::get('pollingadmin', [App\Http\Controllers\AdminController::class, 'pollingadmin'])->middleware(['checkRole:admin']);

Route::get('periodeadmin', [App\Http\Controllers\AdminController::class, 'periodeadmin'])->middleware(['checkRole:admin']);
Route::get('addpollingadmin', [App\Http\Controllers\AdminController::class, 'addpollingadmin'])->middleware(['checkRole:admin'])->name('addpollingadmin');
Route::post('addpollingadmin', [App\Http\Controllers\AdminController::class, 'addpollingprosesadmin'])->middleware(['checkRole:admin'])->name('addpollingprosesadmin');

Route::post('/polling1', [\App\Http\Controllers\MahasiswaController::class, 'polling1'])->name('polling1');
Route::post('/pollingadmin1', [\App\Http\Controllers\AdminController::class, 'pollingadmin1'])->name('pollingadmin1');

Route::get('hasilpolling',[\App\Http\Controllers\MahasiswaController::class, 'hasilpolling'])->name('hasilpolling');
Route::get('hasilpollingadmin',[\App\Http\Controllers\AdminController::class, 'hasilpollingadmin'])->name('hasilpollingadmin');
Route::get('hasilpollingprodi',[\App\Http\Controllers\ProdiController::class, 'hasilpollingprodi'])->name('hasilpollingprodi');

Route::post('savepolling', [\App\Http\Controllers\MahasiswaController::class, 'savepolling'])->name('savepolling');
