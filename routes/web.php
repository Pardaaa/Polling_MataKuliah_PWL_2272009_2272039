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
    return redirect('login');
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

Route::get('mahasiswapolling', [App\Http\Controllers\MahasiswaController::class, 'polling']);
Route::get('mahasiswapolling', [App\Http\Controllers\MahasiswaController::class, 'polling']);
Route::get('mahasiswahasil', [\App\Http\Controllers\MahasiswaController::class, 'hasilPolling']);