<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
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
        $tabel = Mahasiswa::get();
        return view('layouts\admin\datamahasiswadankandidat', compact('tabel'));
    }

    public function hapus($id)
    {
        $tabel = Mahasiswa::find($id);
        Mahasiswa::where('id', $id)->delete();
        return redirect('datamahasiswadankandidat')->with('success', 'Data berhasil di hapus!');
    }

    public function index1()
    {
        $datamatakuliahadmin = Matakuliah::get();
        return view('layouts\admin\datamatakuliahadmin', compact('datamatakuliahadmin'));
    }

    public function hapusmatakuliahadmin($kode_mk)
    {
        $jumlahDataDihapus = Matakuliah::where('kode_mk', $kode_mk)->delete();

        if ($jumlahDataDihapus > 0) {
            return redirect('datamatakuliahadmin')->with('success', 'Data berhasil dihapus!');
        } else {
            return redirect('datamatakuliahadmin')->with('error', 'Data tidak ditemukan!');
        }
    }

    public function addmatakuliahadmin()
    {
        return view('layouts\admin\addmatakuliahadmin');
    }

    public function savematakuliahadmin(Request $request)
    {
        $this->validate($request, [
            'kode_mk' => 'required|unique:matakuliah,kode_mk',
            'nama_mk' => 'required|min:3',
            'sks' =>'required',
        ]);

        $kode_mk = $request->kode_mk;
        $nama_mk = $request->nama_mk;
        $sks = $request->sks;

        $data = new Matakuliah;
        $data->kode_mk = $kode_mk;
        $data->nama_mk = $nama_mk;
        $data->sks = $sks;
        $data->save();

        return redirect('datamatakuliahadmin')->with('success', 'Data berhasil di tambah!');
    }
}