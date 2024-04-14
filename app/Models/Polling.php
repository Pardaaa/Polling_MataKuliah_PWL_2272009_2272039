<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polling extends Model
{
    protected $table = 'polling';
    use HasFactory;

    protected $fillable = [
        'id',
        'nama_polling',
        'start_date',
        'end_date'
    ];


}
