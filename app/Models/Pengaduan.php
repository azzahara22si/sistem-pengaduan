<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PenyaluranPengaduan;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'unit_tujuan',
        'unit_tujuan_awal',
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

    public function penyaluranHistory()
    {
        return $this->hasMany(PenyaluranPengaduan::class)->orderBy('created_at', 'desc');
    }

    // Relasi ke tanggapan (1 pengaduan = banyak tanggapan)
    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class);
    }

    public function unitResponses()
    {
        return $this->tanggapan()->whereHas('user', function ($query) {
            $query->where('role', 'admin');
        });
    }

    public function hasUnitResponse(): bool
    {
        if (array_key_exists('unit_responses_count', $this->attributes)) {
            return (int) $this->attributes['unit_responses_count'] > 0;
        }

        return $this->unitResponses()->exists();
    }

    public function canBeReassigned(): bool
    {
        $status = strtolower($this->status ?? '');

        return in_array($status, ['diajukan', 'proses'], true)
            && !$this->hasUnitResponse();
    }
}
