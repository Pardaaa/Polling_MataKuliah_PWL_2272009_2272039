<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
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
        return view('home');
    }

    public function add()
    {
        return view('layouts\admin\add');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|min:7|unique:users,id|numeric',
            'name' => 'required|min:3',
            'email' =>'required',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $hashedPassword = Hash::make($password);
        $role = $request->role;

        $data = new Mahasiswa;
        $data->id = $id;
        $data->name = $name;
        $data->email = $email;
        $data->password = $hashedPassword;
        $data->role = $role;
        $data->save();

        return redirect('datamahasiswadankandidat')->with('success', 'Data berhasil di tambah!');
    }
}
