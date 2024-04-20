<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Polling;
use App\Models\Matakuliah;
use App\Models\HasilPolling;
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

    public function polling(Request $request)
    {
        $data = Polling::where('start_date', '<=', date('Y-m-d H:i:s', strtotime('+8 hours')))
            ->where('end_date', '>=', date('Y-m-d H:i:s', strtotime('+8 hours')))
            ->first();
        $datamatakuliah = Matakuliah::get();

        if ($datamatakuliah) {
            // Data mata kuliah tersedia, lanjutkan
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

        // Periksa apakah pengguna sudah memilih
        if ($user->hasilpolling->count() > 0) {
            // Redirect ke halaman lain atau tampilkan pesan bahwa pengguna sudah memilih
            return redirect('hasilpolling')->with('error', 'Anda sudah memilih. Tidak bisa memilih lagi.');
        }

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

        return redirect('hasilpolling')->with('success', 'Pemilihan mata kuliah berhasil disimpan.');
    }

    public function hasilpolling()
    {
        $results = DB::table('hasilpolling')
            ->select('kode_mk','nama_mk', 'sks', DB::raw('COUNT(*) as total'))
            ->groupBy('kode_mk','nama_mk', 'sks')
            ->get();

        return view('layouts\mahasiswa\hasilpolling', ['results' => $results]);
    }
    public function changepasswordform()
    {
        return view('layouts\mahasiswa\password');
    }
    public function changepassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check if the current password matches the password in the database
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini salah.');
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return view('layouts\mahasiswa\mahasiswa');
    }

}
