<?php

namespace App\Http\Controllers;

use App\Models\Tanggapan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class TanggapanController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'isi_tanggapan' => 'required',
            'status' => 'nullable|in:diajukan,proses,selesai'
        ]);

        Tanggapan::create([
            'pengaduan_id' => $request->pengaduan_id,
            'user_id' => auth()->id(),
            'isi_tanggapan' => $request->isi_tanggapan
        ]);

        $status = $request->status ?? 'proses';

        Pengaduan::where('id', $request->pengaduan_id)
            ->update(['status' => $status]);

        return redirect()->route('pengaduan.index')->with('success', 'Tanggapan dan status berhasil diperbarui');
    }
}
