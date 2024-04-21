<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        // Implement your admin role logic here
        return $this->role === 'admin';
    }

    /**
     * Determine if the user is in prodi role.
     *
     * @return bool
     */
    public function isProdi()
    {
        // Implement your prodi role logic here
        return $this->role === 'prodi';
    }

    /**
     * Determine if the user is in mahasiswa role.
     *
     * @return bool
     */
    public function isMahasiswa()
    {
        // Implement your mahasiswa role logic here
        return $this->role === 'mahasiswa';
    }

    public function hasilPolling()
    {
        return $this->hasMany(HasilPolling::class, 'NRP', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}