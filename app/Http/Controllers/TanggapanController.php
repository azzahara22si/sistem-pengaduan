<?php

namespace App\Http\Controllers;

use App\Models\Tanggapan;
use App\Models\Pengaduan;
use App\Models\PengaduanStatusHistory;
use App\Mail\PengaduanNotification;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
            $statusBerubah = $pengaduan->status !== $request->status;
            $pengaduan->update(['status' => $request->status]);

            if ($statusBerubah) {
                PengaduanStatusHistory::create([
                    'pengaduan_id' => $pengaduan->id,
                    'status' => $request->status,
                    'user_id' => Auth::id(),
                ]);
            }
        }

        try {
            $recipient = $pengaduan->user?->email;
            if ($recipient) {
                $note = $request->filled('status')
                    ? ('Pengaduan ' . ucfirst($request->status))
                    : 'Ada Tanggapan Baru';

                Mail::to($recipient)->send(new PengaduanNotification($pengaduan, $note, 'mahasiswa'));
            }
        } catch (\Exception $e) {
            report($e);
        }

        return redirect()->route('pengaduan.index')->with('success', 'Tanggapan dan status berhasil diperbarui.');
    }
}
