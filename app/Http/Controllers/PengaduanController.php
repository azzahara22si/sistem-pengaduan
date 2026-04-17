<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    // ================== LIST ==================
    public function index()
    {
        $pengaduans = Pengaduan::latest()->get();
        return view('admin.pengaduan', compact('pengaduans'));
    }

    // ================== CREATE ==================
    public function create()
    {
        return view('pengaduan.create');
    }

    // ================== STORE ==================
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'unit_tujuan' => 'required',
            'urgensi' => 'required',
        ]);

        Pengaduan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'unit_tujuan' => $request->unit_tujuan,
            'urgensi' => $request->urgensi,
            'status' => 'menunggu',
        ]);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dikirim');
    }

    // ================== SHOW ==================
    public function show(Pengaduan $pengaduan)
    {
        return view('pengaduan.show', compact('pengaduan'));
    }

    // ================== EDIT ==================
    public function edit(Pengaduan $pengaduan)
    {
        return view('pengaduan.edit', compact('pengaduan'));
    }

    // ================== UPDATE ==================
    public function update(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'unit_tujuan' => 'required',
            'urgensi' => 'required',
            'status' => 'required',
        ]);

        $pengaduan->update($request->all());

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil diperbarui');
    }

    // ================== DELETE ==================
    public function destroy($id)
    {
        Pengaduan::findOrFail($id)->delete();

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus');
    }

    // ================== REKAPITULASI ==================
    public function rekapitulasi()
{
    $pengaduans = \App\Models\Pengaduan::latest()->get();

    // Statistik (biar nyambung sama card UI kamu)
    $total = $pengaduans->count();
    $selesai = $pengaduans->where('status', 'Selesai')->count();

    return view('admin.rekapitulasi', compact('pengaduans', 'total', 'selesai'));
}

    // ================== DASHBOARD ==================
    public function dashboard()
    {
        $total = Pengaduan::count();
        $menunggu = Pengaduan::where('status', 'menunggu')->count();
        $diproses = Pengaduan::where('status', 'diproses')->count();
        $selesai = Pengaduan::where('status', 'selesai')->count();

        return view('pengaduan.dashboard', compact('total', 'menunggu', 'diproses', 'selesai'));
    }
}