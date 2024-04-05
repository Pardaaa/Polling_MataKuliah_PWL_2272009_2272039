<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
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
}
