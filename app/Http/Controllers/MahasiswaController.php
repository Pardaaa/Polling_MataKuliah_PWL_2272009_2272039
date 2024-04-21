<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Polling;
use App\Models\Matakuliah;
use App\Models\HasilPolling;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function pollingList()
    {
        return view('layouts\mahasiswa\pollingList');
    }

    public function periodemahasiswa(Request $request)
    {
        $data = Polling::orderBy('id', 'desc')->get();
        return view('layouts\mahasiswa\pollingList', compact('data'));
    }


    public function polling(Request $request)
    {
        $polling = $request->polling;

        $data = Polling::where('id', $polling)
            ->where('start_date', '<=', date('Y-m-d H:i:s', strtotime('+8 hours')))
            ->where('end_date', '>=', date('Y-m-d H:i:s', strtotime('+8 hours')))
            ->first();

        if ($data) {
            $datamatakuliah = Matakuliah::get();
            $count = $datamatakuliah->count(); // Periksa jumlah data

            if ($count > 0) {
                // Ada data, lanjutkan dengan tindakan yang sesuai
                return view('layouts\mahasiswa\polling', compact('data', 'datamatakuliah'));
            } else {
                // Tidak ada data, tangani kasus ini sesuai kebutuhan aplikasi
                return redirect()->back()->with('error', 'Tidak ada data mata kuliah yang tersedia.');
            }
        } else {
            // Tangani jika data mata kuliah tidak tersedia
            return redirect()->back()->with('error', 'Data mata kuliah tidak tersedia.');
        }
    }

    public function savepolling(Request $request)
    {
        $user = Auth::user();
        $id = $user->id;
        $name = $user->name;
        $polling_id = $request->input('polling_id');

        $matakuliah = $request->input('matakuliah');
        $total_sks = 0;

        // Hitung total SKS yang dipilih
        foreach ($matakuliah as $kode_mk) {
            $datamatkul = Matakuliah::where('kode_mk', $kode_mk)->first();
            $total_sks += $datamatkul->sks;
        }

        // Batasan maksimum SKS
        $batas_max_sks = 9;

        // Periksa apakah total SKS tidak melebihi batas maksimum
        if ($total_sks > $batas_max_sks) {
            return redirect('hasilpolling')->with('error', 'Maaf, jumlah SKS yang Anda pilih melebihi batas maksimum yang diizinkan.');
        }

        // Hapus hasil polling yang ada berdasarkan polling_id
        $existingPolling = HasilPolling::where('NRP', $id)->whereHas('polling', function($query) use ($polling_id) {
            $query->where('id', $polling_id);
        })->delete();

        foreach ($matakuliah as $kode_mk) {
            $datamatkul = Matakuliah::where('kode_mk', $kode_mk)->first();
            $data = new HasilPolling();
            $data->NRP = $id;
            $data->name = $name;
            $data->kode_mk = $kode_mk;
            $data->nama_mk = $datamatkul->nama_mk;
            $data->sks = $datamatkul->sks;
            $data->polling_id = $polling_id; // Tambahkan polling_id
            $data->save();
        }

        return redirect('hasilpolling')->with('success', 'Pemilihan mata kuliah berhasil disimpan.');
    }

    public function hasilpolling()
    {
        $results = DB::table('hasilpolling')
        ->select('hasilpolling.kode_mk', 'hasilpolling.nama_mk', 'hasilpolling.sks', DB::raw('COUNT(*) as total'), 'polling.nama_polling')
        ->leftJoin('polling', 'polling.id', '=', 'hasilpolling.polling_id')
        ->groupBy('hasilpolling.kode_mk', 'hasilpolling.nama_mk', 'hasilpolling.sks', 'polling.nama_polling')
        ->get();



        // Jika Anda ingin melihat hasil query, Anda bisa menghapus atau mengomentari dd() berikut
        // dd($results);

        return view('layouts.mahasiswa.hasilpolling', ['results' => $results]);
    }

    public function changepasswordform()
    {
        return view('layouts\mahasiswa\password');
    }

    public function changepassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => 'Password berhasil diubah']);
    }

}
