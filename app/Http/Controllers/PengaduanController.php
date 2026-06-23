<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\UnitLayanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PengaduanController extends Controller
{
    private function ensureAdminSpmi(): void
    {
        abort_unless(Auth::user()?->role === 'admin_spmi', 403);
    }

    private function ensureCanView(Pengaduan $pengaduan): void
    {
        $user = Auth::user();

        abort_unless(
            $user->role === 'admin_spmi'
                || ($user->role === 'admin' && (int) $pengaduan->unit_id === (int) $user->unit_id)
                || ($user->role === 'mahasiswa' && (int) $pengaduan->user_id === (int) $user->id),
            403
        );
    }

    private function ensureCanHandle(Pengaduan $pengaduan): void
    {
        $user = Auth::user();

        abort_unless(
            $user->role === 'admin_spmi'
                || ($user->role === 'admin' && (int) $pengaduan->unit_id === (int) $user->unit_id),
            403
        );
    }

    private function ensureCanDelete(Pengaduan $pengaduan): void
    {
        $user = Auth::user();

        abort_unless(
            $user->role === 'mahasiswa'
                && (int) $pengaduan->user_id === (int) $user->id
                && $pengaduan->status === 'diajukan',
            403
        );
    }

    public function dashboard()
    {
        abort_unless(in_array(Auth::user()->role, ['admin', 'admin_spmi'], true), 403);

        $total = Pengaduan::count();
        $diajukan = Pengaduan::where('status', 'diajukan')->count();
        $diproses = Pengaduan::where('status', 'proses')->count();
        $selesai = Pengaduan::where('status', 'selesai')->count();

        return view('pengaduan.dashboard', compact('total', 'diajukan', 'diproses', 'selesai'));
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'unit' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['diajukan', 'proses', 'selesai'])],
            'date' => ['nullable', 'date_format:Y-m-d'],
            'tanggal' => ['nullable', 'date_format:Y-m-d'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $user = Auth::user();
        $units = UnitLayanan::all();

        $query = Pengaduan::query();

        if ($user->role === 'mahasiswa') {
            $query->where('user_id', $user->id)->where('status', '!=', 'selesai');
        } elseif ($user->role === 'admin') {
            $query->where('unit_id', $user->unit_id)->where('status', '!=', 'selesai');
        }

        if ($user->role !== 'admin_spmi') {
            unset($validated['unit']);
        }

        if (!empty($validated['unit'])) {
            $query->where('unit_tujuan', $validated['unit']);
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $selectedDate = $validated['date'] ?? $validated['tanggal'] ?? null;
        if (!empty($selectedDate)) {
            $query->whereDate('created_at', $selectedDate);
        }

        if (!empty($validated['search'])) {
            $search = $validated['search'];
            $query->where('judul', 'LIKE', '%' . $search . '%');
        }

        $pengaduans = $query->orderByRaw("CASE WHEN status = 'selesai' THEN 1 ELSE 0 END ASC")
            ->orderByRaw("CASE WHEN urgensi = 'tinggi' THEN 0 WHEN urgensi = 'sedang' THEN 1 ELSE 2 END ASC")
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pengaduan.index', compact('pengaduans', 'units'));
    }

    public function salurkan(Request $request, $id)
    {
        $this->ensureAdminSpmi();

        $validated = $request->validate([
            'unit_id' => 'required|exists:unit_layanans,id',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        abort_unless($pengaduan->status === 'diajukan', 403);

        $unit = UnitLayanan::findOrFail($validated['unit_id']);

        $pengaduan->update([
            'unit_id' => $unit->id,
            'unit_tujuan' => $unit->nama_unit,
            'status' => 'proses'
        ]);

        return redirect()->back()->with('success', 'Pengaduan telah diteruskan ke unit layanan terkait untuk ditindaklanjuti.');
    }

    public function create()
    {
        abort_unless(Auth::user()->role === 'mahasiswa', 403);

        $units = UnitLayanan::all();
        return view('pengaduan.create', compact('units'));
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->role === 'mahasiswa', 403);

        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string|max:5000',
            'unit_tujuan' => ['required', 'string', 'max:255', Rule::exists('unit_layanans', 'nama_unit')],
            'urgensi' => 'required|in:rendah,sedang,tinggi',
            'klasifikasi' => 'required|in:pengaduan,aspirasi,permintaan_informasi',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048|dimensions:max_width=4096,max_height=4096',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan', 'public');
        }

        Pengaduan::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'unit_tujuan' => $validated['unit_tujuan'],
            'urgensi' => $validated['urgensi'],
            'klasifikasi' => $validated['klasifikasi'],
            'foto' => $fotoPath,
            'status' => 'diajukan',
        ]);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function show(Pengaduan $pengaduan)
    {
        $this->ensureCanView($pengaduan);

        return view('pengaduan.show', compact('pengaduan'));
    }

    public function foto(Pengaduan $pengaduan)
    {
        $this->ensureCanView($pengaduan);

        if (!$pengaduan->foto || !Storage::disk('public')->exists($pengaduan->foto)) {
            abort(404);
        }

        return Storage::disk('public')->response($pengaduan->foto);
    }

    public function edit(Pengaduan $pengaduan)
    {
        abort_unless(Auth::user()->role === 'mahasiswa', 403);
        $this->ensureCanView($pengaduan);

        if ($pengaduan->status !== 'diajukan') {
            return redirect()->back()->with('error', 'Hanya pengaduan dengan status diajukan yang dapat diedit.');
        }

        $units = UnitLayanan::all();
        return view('pengaduan.edit', compact('pengaduan', 'units'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        abort_unless(Auth::user()->role === 'mahasiswa', 403);
        $this->ensureCanView($pengaduan);

        if ($pengaduan->status !== 'diajukan') {
            return redirect()->back()->with('error', 'Hanya pengaduan dengan status diajukan yang dapat diedit.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string|max:5000',
            'unit_tujuan' => ['required', 'string', 'max:255', Rule::exists('unit_layanans', 'nama_unit')],
            'urgensi' => 'required|in:rendah,sedang,tinggi',
            'klasifikasi' => 'required|in:pengaduan,aspirasi,permintaan_informasi',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048|dimensions:max_width=4096,max_height=4096',
        ]);

        $data = [
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'unit_tujuan' => $validated['unit_tujuan'],
            'urgensi' => $validated['urgensi'],
            'klasifikasi' => $validated['klasifikasi'],
        ];

        if ($request->hasFile('foto')) {
            if ($pengaduan->foto) {
                Storage::disk('public')->delete($pengaduan->foto);
            }
            $data['foto'] = $request->file('foto')->store('pengaduan', 'public');
        }

        $pengaduan->update($data);

        return redirect()->route('pengaduan.show', $pengaduan->id)
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $this->ensureCanDelete($pengaduan);

        $pengaduan->delete();

        return redirect()->route('pengaduan.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:diajukan,proses,selesai',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $this->ensureCanHandle($pengaduan);

        $pengaduan->update(['status' => $validated['status']]);

        return redirect()->route('pengaduan.index')->with('success', 'Status pengaduan berhasil diperbarui menjadi ' . ucfirst($validated['status']) . '.');
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
        $this->ensureAdminSpmi();

        $units = UnitLayanan::all()->map(function($unit) {

            $unit->pengaduans_count = Pengaduan::where('unit_id', $unit->id)
                ->orWhere(function($query) use ($unit) {
                    $query->whereNull('unit_id')->where('unit_tujuan', $unit->nama_unit);
                })
                ->count();
            return $unit;
        })->filter(function($unit) {
            return $unit->pengaduans_count > 0;
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
            'feedback' => 'nullable|string|max:2000'
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

        return back()->with('success', 'Terima kasih atas penilaian Anda.');
    }
}
