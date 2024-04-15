<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPolling extends Model
{
    protected $table = 'hasilpolling';
    use HasFactory;

    protected $fillable  = [
        'idpolling',
        'namepolling',
        'kode_mkpolling',
        'nama_mkpolling',
        'skspolling'
    ];
}
