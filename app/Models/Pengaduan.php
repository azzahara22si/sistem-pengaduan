<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'unit_tujuan',
        'urgensi',
        'klasifikasi',
        'foto',
        'status',
        'unit_id',
        'rating',
        'feedback'
    ];

    // Relasi ke user (yang membuat pengaduan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(UnitLayanan::class, 'unit_id');
    }

    // Relasi ke tanggapan (1 pengaduan = 1 tanggapan)
   public function tanggapan()
{
    return $this->hasMany(Tanggapan::class);
}
}