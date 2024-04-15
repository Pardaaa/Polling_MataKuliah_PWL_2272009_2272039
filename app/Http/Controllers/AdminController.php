<?php

namespace App\Http\Controllers;

use App\Models\HasilPolling;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Polling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function periodeadmin(Request $request)
    {
        $data = Polling::orderBy('id', 'desc')->get();
        return view('layouts\admin\periodeadmin', compact('data'));
    }

    public function addpollingadmin(Request $request)
    {
        return view('layouts\admin\addpollingadmin');
    }

    public function addpollingprosesadmin(Request $request)
    {
        $data = new Polling();
        $data->nama_polling = $request->nama_polling;
        $data->start_date = $request->start_date;
        $data->end_date = $request->end_date;
        $data->save();

        return redirect('periodeadmin')->with('success', 'Data berhasil ditambahkan!');
    }

    public function pollingadmin(Request $request)
    {
        $data = Polling::where('start_date', '<=', date('Y-m-d H:i:s', strtotime('+8 hours')))
            ->where('end_date', '>=', date('Y-m-d H:i:s', strtotime('+8 hours')))
            ->first();
        $datamatakuliah = Matakuliah::get();

        return view('layouts\admin\pollingadmin', compact('data', 'datamatakuliah'));
    }

    public function pollingadmin1(Request $request)
    {
        $user = Auth::User();
        $id = $user->id;
        $name = $user->name;


        $matakuliah = $request->input('matakuliah');

        foreach ($matakuliah as $kode_mk) {
            $datamatkul = Matakuliah::where('kode_mk', $kode_mk)->first();
            $data = new HasilPolling();
            $data->NRP = $id;
            $data->name = $name;
            $data->kode_mk = $kode_mk;
            $data->nama_mk = $datamatkul->nama_mk;
            $data->sks = $datamatkul->sks;
            $data->save();
        }

        return redirect()->back()->with('success', 'Polling telah berhasil terkirim.');
    }
    public function hasilPollingadmin()
    {
        $results = DB::table('hasilpolling')
            ->select('kode_mk','nama_mk', 'sks', DB::raw('COUNT(*) as total'))
            ->groupBy('kode_mk','nama_mk', 'sks')
            ->get();

        return view('layouts\admin\hasilPollingAdmin', ['results' => $results]);
    }
}
