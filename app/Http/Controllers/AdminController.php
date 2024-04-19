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
use Validator;

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

    public function editmatakuliahadmin(Matakuliah $matkul)
    {
        return view ('layouts\admin\editmatakuliahadmin', [
            'mhs' => $matkul
        ]);
    }

    public function edituser(Mahasiswa $user)
    {
        return view ('layouts\admin\editUser', [
            'mhs' => $user
        ]);
    }

    public function updateuser (Request $request, Mahasiswa $user)
    {
        $validatedData = validator($request->all(), [
            'id' => 'required|min:7|numeric',
            'name' => 'required|min:3',
            'email' =>'required|email',
            'role' => 'required'
        ]) -> validate();

        $user->update($validatedData);
        return redirect(route('datamahasiswadankandidat'));
    }

    public function savematakuliahadmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_mk' => 'required|unique:matakuliah',
            'nama_mk' => 'required|min:3',
            'sks' =>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $kode_mk = $request->kode_mk;
        $nama_mk = $request->nama_mk;
        $sks = $request->sks;

        $data = new Matakuliah;
        $data->kode_mk = $kode_mk;
        $data->nama_mk = $nama_mk;
        $data->sks = $sks;
        $data->save();

        return response()->json(['success' => 'Data mahasiswa berhasil ditambahkan.']);
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
        $validator = Validator::make($request->all(), [
            'nama_polling' => 'required|unique:polling',
            'start_date' => 'required',
            'end_date' =>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $data = new Polling();
        $data->nama_polling = $request->nama_polling;
        $data->start_date = $request->start_date;
        $data->end_date = $request->end_date;
        $data->save();

        return response()->json(['success' => 'Data polling berhasil ditambahkan.']);
    }

    public function hapuspollingadmin($nama_polling)
    {
        $tabel = Polling::find($nama_polling);
        Polling::where('nama_polling', $nama_polling)->delete();
        return redirect('periodeadmin')->with('success', 'Data berhasil di hapus!');
    }

    public function pollingadmin(Request $request)
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
                return view('layouts\admin\pollingadmin', compact('data', 'datamatakuliah'));
            } else {
                // Tidak ada data, tangani kasus ini sesuai kebutuhan aplikasi
                return redirect()->back()->with('error', 'Tidak ada data mata kuliah yang tersedia.');
            }
        } else {
            // Tangani jika data mata kuliah tidak tersedia
            return redirect()->back()->with('error', 'Data mata kuliah tidak tersedia.');
        }
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

    public function hasilpollingadmin()
    {
        $results = DB::table('hasilpolling')
            ->select('kode_mk','nama_mk', 'sks', DB::raw('COUNT(*) as total'))
            ->groupBy('kode_mk','nama_mk', 'sks')
            ->get();

        return view('layouts\admin\hasilpollingadmin', ['results' => $results]);
    }

    public function add()
    {
        return view('layouts\admin\add');
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|min:7|unique:users|numeric',
            'name' => 'required|min:3',
            'email' =>'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $id = $request->id;
        $nama = $request->name;
        $email = $request->email;
        $password = $request->password;
        $hashedPassword = Hash::make($password);
        $role = $request->role;

        $data = new Mahasiswa;
        $data->id = $id;
        $data->name = $nama;
        $data->email = $email;
        $data->password = $hashedPassword;
        $data->role = $role;
        $data->save();

        return response()->json(['success' => 'Data mahasiswa berhasil ditambahkan.']);
    }
    public function changepasswordformadmin()
    {
        return view('password');
    }
    public function changepasswordadmin(Request $request)
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

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }
}
