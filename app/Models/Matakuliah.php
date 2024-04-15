<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    protected $table = 'matakuliah';
    use HasFactory;
    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks'
    ];
}
