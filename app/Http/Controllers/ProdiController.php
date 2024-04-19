<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Polling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function editmatakuliah(Matakuliah $matkul)
    {
        return view ('layouts\admin\editmatakuliahadmin', [
            'mhs' => $matkul
        ]);
    }

    public function updatematakuliah(Request $request, Matakuliah $matkul)
    {
        $validatedData = validator($request->all(), [
            'nama_mk' => 'required|min:3',
            'sks' =>'required'
        ], [
            'nama_mk.required' => 'Nama Mata Kuliah harus diisi'
        ]) -> validate();

        $matkul->update($validatedData);
        return redirect(route('datamatakuliahadmin'));
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

    public function hapuspolling($nama_polling)
    {
        $tabel = Polling::find($nama_polling);
        Polling::where('nama_polling', $nama_polling)->delete();
        return redirect('periode')->with('success', 'Data berhasil di hapus!');
    }

    public function hasilpollingprodi()
    {
        $results = DB::table('hasilpolling')
            ->select('kode_mk','nama_mk', 'sks', DB::raw('COUNT(*) as total'))
            ->groupBy('kode_mk','nama_mk', 'sks')
            ->get();

        return view('layouts\prodi\hasilpollingprodi', ['results' => $results]);
    }
    public function changepasswordformprodi()
    {
        return view('password');
    }
    public function changepasswordprodi(Request $request)
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
