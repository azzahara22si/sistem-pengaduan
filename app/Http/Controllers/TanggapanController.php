<?php

namespace App\Http\Controllers;

use App\Models\Tanggapan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class TanggapanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,admin_spmi');
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'isi_tanggapan' => 'required|string|max:5000',
            'status' => 'nullable|in:diajukan,proses,selesai'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        if (Auth::user()->role === 'admin' && (int) $pengaduan->unit_id !== (int) Auth::user()->unit_id) {
            // Admin users must only handle complaints for their own unit.
            abort(403);
        }

        Tanggapan::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id' => Auth::id(),
            'isi_tanggapan' => $request->isi_tanggapan
        ]);

        if ($request->filled('status')) {
            $pengaduan->update(['status' => $request->status]);
        }

        return redirect()->route('pengaduan.index')->with('success', 'Tanggapan dan status berhasil diperbarui.');
    }
}
