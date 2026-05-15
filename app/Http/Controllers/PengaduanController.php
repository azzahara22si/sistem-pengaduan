<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\UnitLayanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $units = UnitLayanan::all();

        $query = Pengaduan::query();

        if ($user->role === 'mahasiswa') {
            $query->where('user_id', $user->id)->where('status', '!=', 'selesai');
        } elseif ($user->role === 'admin') {
            $query->where('unit_id', $user->unit_id)->where('status', '!=', 'selesai');
        }

        if ($request->filled('unit')) {
            $query->where('unit_tujuan', $request->unit);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'LIKE', '%' . $request->search . '%');
            });
        }

        $pengaduans = $query->orderByRaw("CASE WHEN status = 'selesai' THEN 1 ELSE 0 END ASC")
            ->orderByRaw("CASE WHEN urgensi = 'tinggi' THEN 0 WHEN urgensi = 'sedang' THEN 1 ELSE 2 END ASC")
            ->latest()
            ->paginate(10);

        return view('pengaduan.index', compact('pengaduans', 'units'));
    }

    public function salurkan(Request $request, $id)
    {
        $request->validate([
            'unit_id' => 'required|exists:unit_layanans,id',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update([
            'unit_id' => $request->unit_id,
            'status' => 'proses'
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil disalurkan ke unit terkait.');
    }

    public function create()
    {
        $units = UnitLayanan::all();
        return view('pengaduan.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'unit_tujuan' => 'required',
            'urgensi' => 'required',
            'klasifikasi' => 'required|in:pengaduan,aspirasi,permintaan_informasi',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan', 'public');
        }

        Pengaduan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'unit_tujuan' => $request->unit_tujuan,
            'urgensi' => $request->urgensi,
            'klasifikasi' => $request->klasifikasi,
            'foto' => $fotoPath,
            'status' => 'menunggu',
        ]);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dikirim');
    }

    public function show(Pengaduan $pengaduan)
    {
        return view('pengaduan.show', compact('pengaduan'));
    }

    public function edit(Pengaduan $pengaduan)
    {
        if (Auth::user()->role === 'mahasiswa' && $pengaduan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit aduan ini.');
        }

        if ($pengaduan->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Hanya pengaduan dengan status menunggu yang dapat diedit.');
        }

        $units = UnitLayanan::all();
        return view('pengaduan.edit', compact('pengaduan', 'units'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        if (Auth::user()->role === 'mahasiswa' && $pengaduan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit aduan ini.');
        }

        if ($pengaduan->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Hanya pengaduan dengan status menunggu yang dapat diedit.');
        }

        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'unit_tujuan' => 'required',
            'urgensi' => 'required',
            'klasifikasi' => 'required|in:pengaduan,aspirasi,permintaan_informasi',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'unit_tujuan' => $request->unit_tujuan,
            'urgensi' => $request->urgensi,
            'klasifikasi' => $request->klasifikasi,
        ];

        if ($request->hasFile('foto')) {
            if ($pengaduan->foto) {
                Storage::disk('public')->delete($pengaduan->foto);
            }
            $data['foto'] = $request->file('foto')->store('pengaduan', 'public');
        }

        $pengaduan->update($data);

        return redirect()->route('pengaduan.show', $pengaduan->id)
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if (Auth::user()->role === 'mahasiswa' && $pengaduan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus aduan ini.');
        }

        if (Auth::user()->role === 'mahasiswa' && $pengaduan->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Pengaduan yang sudah diproses tidak dapat dihapus.');
        }

        $pengaduan->delete();

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => $request->status]);

        return redirect()->route('pengaduan.index')->with('success', 'Status pengaduan berhasil diperbarui menjadi ' . ucfirst($request->status));
    }

    public function riwayat()
    {
        $user = Auth::user();
        $query = Pengaduan::where('status', 'selesai')->latest();

        if ($user->role === 'admin') {
            $query->where('unit_id', $user->unit_id);
        } elseif ($user->role === 'mahasiswa') {
            $query->where('user_id', $user->id);
        }

        $pengaduans = $query->paginate(10);

        return view('pengaduan.riwayat', compact('pengaduans'));
    }

    public function rekapitulasi(Request $request)
    {
        $units = UnitLayanan::all()->map(function($unit) {

            $unit->pengaduans_count = Pengaduan::where('unit_id', $unit->id)
                ->orWhere(function($query) use ($unit) {
                    $query->whereNull('unit_id')->where('unit_tujuan', $unit->nama_unit);
                })
                ->count();
            return $unit;
        });

        $totalPengaduan = Pengaduan::count();
        $statusStats = Pengaduan::select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $monthlyStats = Pengaduan::select(
                \Illuminate\Support\Facades\DB::raw('MONTH(created_at) as month'), 
                \Illuminate\Support\Facades\DB::raw('count(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $allPengaduans = Pengaduan::with('user')->latest()->paginate(15);

        $exportData = Pengaduan::with('user')->latest()->get();

        return view('admin-spmi.rekapitulasi', compact('units', 'totalPengaduan', 'statusStats', 'monthlyStats', 'allPengaduans', 'exportData'));
    }

    public function storeFeedback(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        if (Auth::user()->role !== 'mahasiswa' || $pengaduan->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak memberikan penilaian untuk pengaduan ini.');
        }

        if ($pengaduan->status !== 'selesai') {
            return back()->with('error', 'Pengaduan belum selesai.');
        }

        $pengaduan->update([
            'rating' => $request->rating,
            'feedback' => $request->feedback
        ]);

        return back()->with('success', 'Terima kasih atas penilaian Anda!');
    }
}