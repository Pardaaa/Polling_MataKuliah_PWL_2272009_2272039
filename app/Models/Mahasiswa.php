<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role'
    ];
}
