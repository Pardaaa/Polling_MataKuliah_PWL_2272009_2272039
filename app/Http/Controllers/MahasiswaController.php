<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Polling;
use App\Models\Matakuliah;
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
}