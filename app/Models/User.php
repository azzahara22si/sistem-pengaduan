<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Mass Assignable
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role' // ✅ WAJIB ADA
    ];

    /**
     * Hidden
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // =========================
    // ROLE HELPER
    // =========================

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}