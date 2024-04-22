<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Mahasiswa;
use App\Models\HasilPolling;
use App\Models\Polling;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

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

    public function prodi()
    {
        return view('layouts/prodi/prodi');
    }

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
        return view ('layouts\prodi\editMatakuliah', [
            'mhs' => $matkul
        ]);
    }

    public function updatematakuliah(Request $request, Matakuliah $matkul)
    {
        $validatedData = validator($request->all(), [
            'kode_mk' => 'required',
            'nama_mk' => 'required|min:3',
            'sks' =>'required'
        ]) -> validate();

        $matkul->update($validatedData);
        return response()->json(['success' => 'Data polling berhasil diedit.']);
    }

    public function savematakuliah(Request $request)
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

    public function periode(Request $request)
    {
        $data = Polling::orderBy('id', 'desc')->get();
        return view('layouts\prodi\periode', compact('data'));
    }

    public function addpolling(Request $request)
    {
        return view('layouts\prodi\addpolling');
    }

    public function editPeriode(Polling $pollings)
    {
        return view ('layouts\prodi\editPeriode', [
            'periode' => $pollings
        ]);
    }

    public function updatePeriode (Request $request, Polling $pollings)
    {
        $validatedData = validator($request->all(), [
            'nama_polling' => 'required',
            'start_date' => 'required',
            'end_date' =>'required'
        ]) -> validate();

        $pollings->update($validatedData);
        return response()->json(['success' => 'Data polling berhasil diedit.']);
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

    public function hasilpollingprodi(Request $request)
    {
        $periodeId = $request->input('periode');

        $resultsQuery = DB::table('hasilpolling')
            ->select('hasilpolling.kode_mk', 'hasilpolling.nama_mk', 'hasilpolling.sks', DB::raw('COUNT(*) as total'), 'polling.nama_polling')
            ->leftJoin('polling', 'polling.id', '=', 'hasilpolling.polling_id');

        if ($periodeId) {
            $resultsQuery->where('hasilpolling.polling_id', $periodeId);
        }

        $results = $resultsQuery->groupBy('hasilpolling.kode_mk', 'hasilpolling.nama_mk', 'hasilpolling.sks', 'polling.nama_polling')
            ->get();

        $mahasiswaPollingQuery = DB::table('hasilpolling')
            ->select('users.name')
            ->leftJoin('users', 'users.id', '=', 'hasilpolling.NRP');

        if ($periodeId) {
            $mahasiswaPollingQuery->where('hasilpolling.polling_id', $periodeId);
        }

        $mahasiswaPolling = $mahasiswaPollingQuery->groupBy('users.name')
            ->get();

        $periodes = Polling::all();

        return view('layouts.prodi.hasilpollingprodi', [
            'results' => $results,
            'periodes' => $periodes,
            'selectedPeriode' => $periodeId,
            'mahasiswaPolling' => $mahasiswaPolling
        ]);
    }

    public function changepasswordformprodi()
    {
        return view('layouts\prodi\passwordprodi');
    }

    public function changepasswordprodi(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => ['Password saat ini salah']], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => 'Password berhasil diubah']);
    }
}
