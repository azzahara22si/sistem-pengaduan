<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\PengaduanStatusHistory;
use App\Models\PenyaluranPengaduan;
use App\Models\UnitLayanan;
use App\Models\User;
use App\Mail\PengaduanNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PengaduanController extends Controller
{
    private function calculateWorkingHours($start, $end): float
    {
        if ($end->lte($start)) {
            return 0;
        }

        $workingMinutes = 0;
        $currentDay = $start->copy()->startOfDay();

        while ($currentDay->lte($end)) {
            if ($currentDay->isWeekday()) {
                $workStart = $currentDay->copy()->setTime(7, 0);
                $workEnd = $currentDay->isFriday()
                    ? $currentDay->copy()->setTime(16, 30)
                    : $currentDay->copy()->setTime(16, 0);
                $intervalStart = $start->greaterThan($workStart) ? $start : $workStart;
                $intervalEnd = $end->lessThan($workEnd) ? $end : $workEnd;

                if ($intervalEnd->gt($intervalStart)) {
                    $workingMinutes += $intervalStart->diffInMinutes($intervalEnd);
                }
            }

            $currentDay->addDay();
        }

        return $workingMinutes / 60;
    }

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

    public function pantau()
    {
        abort_unless(Auth::user()->role === 'admin_spmi', 403);

        $pengaduans = Pengaduan::latest()->paginate(10);
        return view('pengaduan.kelola.pengaduan', compact('pengaduans'));
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'unit' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['diajukan', 'proses', 'selesai'])],
            'date' => ['nullable', 'date_format:Y-m-d'],
            'tanggal' => ['nullable', 'date_format:Y-m-d'],
            'date_from' => ['nullable', 'date_format:Y-m-d', 'before_or_equal:date_to'],
            'date_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:date_from'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $user = Auth::user();
        $units = UnitLayanan::all();

        $query = Pengaduan::query()
            ->with(['user', 'unit'])
            ->withCount([
                'tanggapan as unit_responses_count' => function ($query) {
                    $query->whereHas('user', function ($userQuery) {
                        $userQuery->where('role', 'admin');
                    });
                },
            ]);

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
        if (!empty($validated['date_from'])) {
            $query->whereDate('created_at', '>=', $validated['date_from']);
        }
        if (!empty($validated['date_to'])) {
            $query->whereDate('created_at', '<=', $validated['date_to']);
        }

        if (!empty($validated['search'])) {
            $search = $validated['search'];
            $query->where('judul', 'LIKE', '%' . $search . '%');
        }

        if (Auth::user()->role === 'admin_spmi') {
            $pengaduans = $query
                ->orderByRaw("CASE WHEN status = 'selesai' THEN 1 ELSE 0 END ASC")
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } else {
            $pengaduans = $query->orderByRaw("CASE WHEN status = 'selesai' THEN 1 ELSE 0 END ASC")
                ->orderByRaw("CASE WHEN urgensi = 'tinggi' THEN 0 WHEN urgensi = 'sedang' THEN 1 ELSE 2 END ASC")
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view('pengaduan.index', compact('pengaduans', 'units'));
    }

    public function salurkan(Request $request, $id)
    {
        $this->ensureAdminSpmi();

        $validated = $request->validate([
            'unit_id' => 'required|exists:unit_layanans,id',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $unit = UnitLayanan::findOrFail($validated['unit_id']);

        $isInitialDistribution = $pengaduan->status === 'diajukan';

        DB::transaction(function () use ($pengaduan, $unit) {
            $pengaduan->refresh();
            abort_unless($pengaduan->canBeReassigned(), 403);

            $fromUnitId = $pengaduan->unit_id;
            $fromUnitTujuan = $pengaduan->unit_tujuan;

            $pengaduan->update([
                'unit_id' => $unit->id,
                'unit_tujuan' => $unit->nama_unit,
                'status' => 'proses',
            ]);

            PenyaluranPengaduan::create([
                'pengaduan_id' => $pengaduan->id,
                'from_unit_id' => $fromUnitId,
                'from_unit_tujuan' => $fromUnitTujuan,
                'to_unit_id' => $unit->id,
                'to_unit_tujuan' => $unit->nama_unit,
                'user_id' => Auth::id(),
            ]);
        });

        $message = $isInitialDistribution
            ? 'Pengaduan telah diteruskan ke unit layanan terkait untuk ditindaklanjuti.'
            : 'Penyaluran pengaduan berhasil diperbarui.';

        // Notify unit admins that a pengaduan has been forwarded to their unit
        try {
            $unitAdmins = User::where('role', 'admin')->where('unit_id', $unit->id)->whereNotNull('email')->get();
            foreach ($unitAdmins as $unitAdmin) {
                $note = 'Pengaduan Diteruskan ke Unit ' . $unit->nama_unit;
                Mail::to($unitAdmin->email)->send(new PengaduanNotification($pengaduan, $note, 'admin_unit'));
            }
        } catch (\Exception $e) {
            report($e);
        }

        return redirect()->back()->with('success', $message);
    }

    public function export(Request $request)
    {
        $this->ensureAdminSpmi();

        $validated = $request->validate([
            'unit' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['diajukan', 'proses', 'selesai'])],
            'date' => ['nullable', 'date_format:Y-m-d'],
            'date_from' => ['nullable', 'date_format:Y-m-d', 'before_or_equal:date_to'],
            'date_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:date_from'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $query = Pengaduan::with('user');

        if (!empty($validated['unit'])) {
            $query->where('unit_tujuan', $validated['unit']);
        }
        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }
        if (!empty($validated['date'])) {
            $query->whereDate('created_at', $validated['date']);
        }
        if (!empty($validated['date_from'])) {
            $query->whereDate('created_at', '>=', $validated['date_from']);
        }
        if (!empty($validated['date_to'])) {
            $query->whereDate('created_at', '<=', $validated['date_to']);
        }
        if (!empty($validated['search'])) {
            $query->where('judul', 'LIKE', '%' . $validated['search'] . '%');
        }

        $pengaduans = $query
            ->orderByRaw("CASE WHEN status = 'selesai' THEN 1 ELSE 0 END ASC")
            ->latest()
            ->get();

        $rows = $pengaduans->map(function ($pengaduan) {
            return '<tr>'
                . '<td>' . e($pengaduan->created_at->format('d/m/Y H:i')) . '</td>'
                . '<td>' . e($pengaduan->judul) . '</td>'
                . '<td>' . e($pengaduan->unit_tujuan_awal ?: $pengaduan->unit_tujuan) . '</td>'
                . '<td>' . e($pengaduan->unit_id ? $pengaduan->unit_tujuan : 'Belum ditetapkan') . '</td>'
                . '<td>' . e($pengaduan->getReporterName()) . '</td>'
                . '<td>' . e(ucfirst($pengaduan->urgensi)) . '</td>'
                . '<td>' . e(ucfirst($pengaduan->status)) . '</td>'
                . '</tr>';
        })->implode('');

        $html = '<html><head><meta charset="utf-8"><style>'
            . 'table{border-collapse:collapse;width:100%}th,td{border:1px solid #cbd5e1;padding:7px;text-align:left}th{background:#0d428e;color:#fff}.title{font-size:18px;font-weight:bold;text-align:center}'
            . '</style></head><body>'
            . '<div class="title">LAPORAN KELOLA PENGADUAN</div>'
            . '<p style="text-align:center">Diekspor pada ' . e(now()->format('d/m/Y H:i')) . ' WIB</p>'
            . '<table><thead><tr><th>Waktu</th><th>Judul</th><th>Unit Tujuan</th><th>Unit Penanganan</th><th>Pelapor</th><th>Urgensi</th><th>Status</th></tr></thead><tbody>'
            . $rows . '</tbody></table></body></html>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="kelola_pengaduan_' . now()->format('Y-m-d') . '.xls"',
        ]);
    }

    public function print(Request $request)
    {
        $this->ensureAdminSpmi();

        $params = $request->only(['unit', 'status', 'date', 'date_from', 'date_to', 'search', 'klasifikasi', 'tanggal']);

        $query = Pengaduan::with('user');

        if (!empty($params['klasifikasi'])) {
            $query->where('klasifikasi', $params['klasifikasi']);
        }
        if (!empty($params['unit'])) {
            $query->where('unit_tujuan', $params['unit']);
        }
        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }
        $date = $params['date'] ?? $params['tanggal'] ?? null;
        if (!empty($date)) {
            $query->whereDate('created_at', $date);
        }
        if (!empty($params['date_from'])) {
            $query->whereDate('created_at', '>=', $params['date_from']);
        }
        if (!empty($params['date_to'])) {
            $query->whereDate('created_at', '<=', $params['date_to']);
        }
        if (!empty($params['search'])) {
            $query->where('judul', 'LIKE', '%' . $params['search'] . '%');
        }

        $pengaduans = $query->orderByRaw("CASE WHEN status = 'selesai' THEN 1 ELSE 0 END ASC")
            ->latest()
            ->get();

        return view('pengaduan.print', compact('pengaduans'));
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
            'is_anonymous' => 'nullable|boolean',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan', 'public');
        }

        $pengaduan = Pengaduan::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'unit_tujuan' => $validated['unit_tujuan'],
            'unit_tujuan_awal' => $validated['unit_tujuan'],
            'urgensi' => $validated['urgensi'],
            'klasifikasi' => $validated['klasifikasi'],
            'foto' => $fotoPath,
            'status' => 'diajukan',
            'is_anonymous' => $validated['is_anonymous'] ?? false,
        ]);

        PengaduanStatusHistory::create([
            'pengaduan_id' => $pengaduan->id,
            'status' => 'diajukan',
        ]);

        // Notify admin SPMI about new pengaduan
        try {
            $adminSpmiUsers = User::where('role', 'admin_spmi')->whereNotNull('email')->get();
            foreach ($adminSpmiUsers as $adminSpmi) {
                Mail::to($adminSpmi->email)->send(new PengaduanNotification($pengaduan, null, 'admin_spmi'));
            }
        } catch (\Exception $e) {
            report($e);
        }

        return redirect()->route('pengaduan.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function show(Pengaduan $pengaduan)
    {
        $this->ensureCanView($pengaduan);

        $pengaduan->load(['statusHistory.user', 'penyaluranHistory.user', 'tanggapan.user']);

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
            'is_anonymous' => 'nullable|boolean',
        ]);

        $data = [
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'unit_tujuan' => $validated['unit_tujuan'],
            'unit_tujuan_awal' => $validated['unit_tujuan'],
            'urgensi' => $validated['urgensi'],
            'klasifikasi' => $validated['klasifikasi'],
            'is_anonymous' => $validated['is_anonymous'] ?? false,
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

        $statusBerubah = $pengaduan->status !== $validated['status'];
        $pengaduan->update(['status' => $validated['status']]);

        if ($statusBerubah) {
            PengaduanStatusHistory::create([
                'pengaduan_id' => $pengaduan->id,
                'status' => $validated['status'],
                'user_id' => Auth::id(),
            ]);
        }

        try {
            $recipient = $pengaduan->user?->email;
            if ($recipient) {
                $note = match ($validated['status']) {
                    'proses' => 'Pengaduan Sedang Diproses',
                    'selesai' => 'Pengaduan Telah Selesai',
                    default => 'Status Pengaduan Diperbarui',
                };

                Mail::to($recipient)->send(new PengaduanNotification($pengaduan, $note, 'mahasiswa'));
            }
        } catch (\Exception $e) {
            report($e);
        }

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

        $validated = $request->validate([
            'periode' => ['nullable', Rule::in(['today', '7days', 'monthly', 'year', 'custom'])],
            'bulan' => ['nullable', 'date_format:Y-m'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        $periode = $validated['periode'] ?? 'year';
        $now = now();

        [$tanggalMulai, $tanggalSelesai, $labelPeriode] = match ($periode) {
            'today' => [$now->copy()->startOfDay(), $now->copy()->endOfDay(), 'Hari ini'],
            '7days' => [$now->copy()->subDays(6)->startOfDay(), $now->copy()->endOfDay(), '7 hari terakhir'],
            'year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear(), 'Tahun ' . $now->year],
            'monthly' => [
                isset($validated['bulan']) ? \Carbon\Carbon::createFromFormat('Y-m', $validated['bulan'])->startOfMonth() : $now->copy()->startOfMonth(),
                isset($validated['bulan']) ? \Carbon\Carbon::createFromFormat('Y-m', $validated['bulan'])->endOfMonth() : $now->copy()->endOfMonth(),
                isset($validated['bulan']) ? \Carbon\Carbon::createFromFormat('Y-m', $validated['bulan'])->translatedFormat('F Y') : $now->translatedFormat('F Y'),
            ],
            'custom' => [
                isset($validated['tanggal_mulai']) ? \Carbon\Carbon::parse($validated['tanggal_mulai'])->startOfDay() : $now->copy()->startOfMonth(),
                isset($validated['tanggal_selesai']) ? \Carbon\Carbon::parse($validated['tanggal_selesai'])->endOfDay() : $now->copy()->endOfDay(),
                'Periode pilihan',
            ],
            default => [$now->copy()->startOfYear(), $now->copy()->endOfYear(), 'Tahun ' . $now->year],
        };

        $baseQuery = Pengaduan::query()->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);

        $units = UnitLayanan::all()->map(function($unit) use ($baseQuery) {
            $unitQuery = (clone $baseQuery)->where(function ($query) use ($unit) {
                $query->where('unit_id', $unit->id)
                    ->orWhere(function($query) use ($unit) {
                        $query->whereNull('unit_id')->where('unit_tujuan', $unit->nama_unit);
                    });
            });

            $unit->pengaduans_count = (clone $unitQuery)->count();
            $unit->selesai_count = (clone $unitQuery)->where('status', 'selesai')->count();
            $unit->proses_count = (clone $unitQuery)->where('status', 'proses')->count();

            return $unit;
        })->filter(function($unit) {
            return $unit->pengaduans_count > 0;
        });

        $totalPengaduan = (clone $baseQuery)->count();
        $statusStats = (clone $baseQuery)->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $monthlyStats = (clone $baseQuery)->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $categoryStats = (clone $baseQuery)->select('klasifikasi', DB::raw('count(*) as total'))
            ->groupBy('klasifikasi')
            ->get();

        $urgencyStats = (clone $baseQuery)->select('urgensi', DB::raw('count(*) as total'))
            ->groupBy('urgensi')
            ->get();

        $selesaiPengaduans = (clone $baseQuery)->where('status', 'selesai')->with('tanggapan')->get();
        $durasiPenyelesaian = $selesaiPengaduans
            ->map(function ($pengaduan) {
                $waktuSelesai = $pengaduan->tanggapan->max('created_at') ?? $pengaduan->updated_at;

                return $this->calculateWorkingHours($pengaduan->created_at, $waktuSelesai);
            })
            ->filter(fn ($jam) => $jam >= 0);

        $rataRataPenyelesaianJam = round($durasiPenyelesaian->avg() ?? 0, 1);
        $selesaiSesuaiSla = $durasiPenyelesaian->filter(fn ($jam) => $jam <= 45)->count();
        $slaPersentase = $selesaiPengaduans->isNotEmpty()
            ? round(($selesaiSesuaiSla / $selesaiPengaduans->count()) * 100, 1)
            : 0;
        $pengaduanTerlambat = (clone $baseQuery)
            ->where('status', 'proses')
            ->where('created_at', '<', $now->copy()->subDays(7))
            ->count();
        $rataRataRating = round((float) ((clone $baseQuery)->whereNotNull('rating')->avg('rating') ?? 0), 1);
        $jumlahRating = (clone $baseQuery)->whereNotNull('rating')->count();

        $jumlahHari = max($tanggalMulai->copy()->startOfDay()->diffInDays($tanggalSelesai->copy()->startOfDay()) + 1, 1);
        $periodeSebelumnyaSelesai = $tanggalMulai->copy()->subSecond();
        $periodeSebelumnyaMulai = $periodeSebelumnyaSelesai->copy()->subDays($jumlahHari - 1)->startOfDay();
        $totalPeriodeSebelumnya = Pengaduan::whereBetween('created_at', [$periodeSebelumnyaMulai, $periodeSebelumnyaSelesai])->count();
        $perubahanPersentase = $totalPeriodeSebelumnya > 0
            ? round((($totalPengaduan - $totalPeriodeSebelumnya) / $totalPeriodeSebelumnya) * 100, 1)
            : null;

        return view('admin-spmi.rekapitulasi', compact('units', 'totalPengaduan', 'statusStats', 'monthlyStats', 'categoryStats', 'urgencyStats', 'periode', 'tanggalMulai', 'tanggalSelesai', 'labelPeriode', 'rataRataPenyelesaianJam', 'slaPersentase', 'pengaduanTerlambat', 'rataRataRating', 'jumlahRating', 'perubahanPersentase'));
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
