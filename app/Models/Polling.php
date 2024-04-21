<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polling extends Model
{
    use HasFactory;

    protected $table = 'polling';

    protected $fillable = [
        'nama_polling',
        'start_date',
        'end_date'
    ];

    public function hasilpolling()
    {
        return $this->hasMany(HasilPolling::class, 'polling_id', 'id');
    }
}

