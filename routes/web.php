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
Auth::routes();

Route::get('datamahasiswadankandidat', function () { return view('layouts\admin\datamahasiswadankandidat'); })->middleware('checkRole:admin');
Route::get('datamahasiswa', function () { return view('layouts\prodi\datamahasiswa'); })->middleware('checkRole:prodi');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/datamahasiswa', [App\Http\Controllers\MahasiswaController::class, 'index'])->name('datamahasiswa');
Route::get('/datamahasiswadankandidat', [App\Http\Controllers\AdminController::class, 'index'])->name('datamahasiswadankandidat');
Route::get('admin', function () { return view('layouts\admin\admin'); })->middleware('checkRole:admin');
Route::get('prodi', function () { return view('layouts\prodi\prodi'); })->middleware(['checkRole:prodi,admin']);
Route::get('mahasiswa', function () { return view('layouts\mahasiswa\mahasiswa'); })->middleware(['checkRole:mahasiswa,admin']);
Route::get('polling', function () { return view('layouts\admin\polling'); })->middleware('checkRole:admin');
Route::delete('hapus/{id}', [App\Http\Controllers\AdminController::class, 'hapus'])->name('hapus');