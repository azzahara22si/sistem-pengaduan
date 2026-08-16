<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyaluranPengaduan extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'pengaduan_id',
        'from_unit_id',
        'from_unit_tujuan',
        'to_unit_id',
        'to_unit_tujuan',
        'user_id',
        'created_at',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function fromUnit()
    {
        return $this->belongsTo(UnitLayanan::class, 'from_unit_id');
    }

    public function toUnit()
    {
        return $this->belongsTo(UnitLayanan::class, 'to_unit_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
