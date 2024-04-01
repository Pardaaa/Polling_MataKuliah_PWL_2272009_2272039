<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
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
        return view('layouts\mahasiswa\datamahasiswa', compact('data'));
    }

    public function hapus($id)
    {
        $data = Mahasiswa::find($id);
        Mahasiswa::where('id', $id)->delete();
        return redirect('datamahasiswa')->with('success', 'Data berhasil di hapus!');
    }
}
