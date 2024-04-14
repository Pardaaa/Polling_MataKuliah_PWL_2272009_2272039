<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Polling;
use App\Models\Matakuliah;
use App\Models\hasilpolling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
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
        $data = Mahasiswa::where('role', 'mahasiswa')->get();
        return view('layouts\prodi\datamahasiswa', compact('data'));
    }

    public function polling(Request $request)
    {
        $data = Polling::where('start_date', '<=', date('Y-m-d H:i:s', strtotime('+8 hours')))
            ->where('end_date', '>=', date('Y-m-d H:i:s', strtotime('+8 hours')))
            ->first();
        $datamatakuliah = Matakuliah::get();

        return view('layouts\mahasiswa\polling', compact('data', 'datamatakuliah'));
    }

    public function polling1(Request $request)
    {
        $user = Auth::User();

        $this->validate($request, [
            'nama_mk' => 'required|min:3',
            'sks' =>'required',
        ]);


        $id = $user->id;
        $name = $user->name;
        $kode_mk = $request->kode_mk;
        $nama_mk = $request->nama_mk;
        $sks = $request->sks;

        $data = new HasilPolling();
        $data->id = $id;
        $data->name = $name;
        $data->kode_mk = $kode_mk;
        $data->nama_mk = $nama_mk;
        $data->sks = $sks;
        $data->save();


        return redirect()->route('polling')->with('success', 'Polling telah berhasil terkirim.');
    }
}

