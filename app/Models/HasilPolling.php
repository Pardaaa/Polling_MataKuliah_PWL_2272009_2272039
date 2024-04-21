<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPolling extends Model
{
    use HasFactory;

    protected $table = 'hasilpolling';

    protected $fillable = [
        'NRP',
        'name',
        'kode_mk',
        'nama_mk',
        'sks',
        'polling_id'
    ];

    public function polling()
    {
        return $this->belongsTo(Polling::class, 'kode_mk', 'id');
    }
}
