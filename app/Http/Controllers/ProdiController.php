<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function dashboard()
    {
        return view('Prodi.prodi');
    }
}
