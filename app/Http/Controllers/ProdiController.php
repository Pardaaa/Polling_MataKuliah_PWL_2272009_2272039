<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProdiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $datamatakuliah = Matakuliah::get();
        return view('layouts\prodi\datamatakuliah', compact('datamatakuliah'));
    }

    public function hapusmatakuliah($kode_mk)
    {
        $jumlahDataDihapus = Matakuliah::where('kode_mk', $kode_mk)->delete();

        if ($jumlahDataDihapus > 0) {
            return redirect('datamatakuliah')->with('success', 'Data berhasil dihapus!');
        } else {
            return redirect('datamatakuliah')->with('error', 'Data tidak ditemukan!');
        }
    }
}
