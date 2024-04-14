<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Polling;
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

    public function addmatakuliah()
    {
        return view('layouts\prodi\addmatakuliah');
    }

    public function savematakuliah(Request $request)
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

        return redirect('datamatakuliah')->with('success', 'Data berhasil di tambah!');
    }
    public function periode(Request $request)
    {
        $data = Polling::orderBy('id', 'desc')->get();
        return view('layouts\prodi\periode', compact('data'));
    }

    public function addpolling(Request $request)
    {
        return view('layouts\prodi\addpolling');
    }

    public function addpollingproses(Request $request)
    {
        $data = new Polling();
        $data->nama_polling = $request->nama_polling;
        $data->start_date = $request->start_date;
        $data->end_date = $request->end_date;
        $data->save();

        return redirect('periode')->with('success', 'Data berhasil ditambahkan!');
    }
}
