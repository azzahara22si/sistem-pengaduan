<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitLayanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_unit',
        'deskripsi_unit',
        'email_unit',
    ];

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'unit_id');
    }
}
