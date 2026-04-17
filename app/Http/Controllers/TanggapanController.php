<?php

namespace App\Http\Controllers;

use App\Models\Tanggapan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class TanggapanController extends Controller
{
    public function store(Request $request)
    {
        Tanggapan::create([
            'pengaduan_id' => $request->pengaduan_id,
            'user_id' => auth()->id(),
            'isi_tanggapan' => $request->isi_tanggapan
        ]);

        // otomatis ubah status
        Pengaduan::where('id', $request->pengaduan_id)
            ->update(['status' => 'proses']);

        return back()->with('success', 'Tanggapan berhasil dikirim');
    }
}