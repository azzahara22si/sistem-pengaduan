<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitLayanan;

use Illuminate\Support\Facades\Auth;

class UnitLayananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin_spmi');
    }

    public function index()
    {
        $search = request()->query('search', '');
        $query = UnitLayanan::query();
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nama_unit', 'LIKE', '%' . $search . '%')
                  ->orWhere('email_unit', 'LIKE', '%' . $search . '%');
            });
        }

        $units = $query->orderBy('nama_unit')->paginate(15)->withQueryString();
        return view('admin-spmi.kelola-unit', compact('units', 'search'));
    }

    public function export(Request $request)
    {
        $search = $request->query('search', '');
        $query = UnitLayanan::query();
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nama_unit', 'LIKE', '%' . $search . '%')
                  ->orWhere('email_unit', 'LIKE', '%' . $search . '%');
            });
        }

        $units = $query->orderBy('nama_unit')->get();

        $filename = 'unit_layanan_export_' . now()->format('Ymd_His') . '.xls';
        $content = view('admin-spmi.unit-export', compact('units'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function print(Request $request)
    {
        $search = $request->query('search', '');
        $query = UnitLayanan::query();
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nama_unit', 'LIKE', '%' . $search . '%')
                  ->orWhere('email_unit', 'LIKE', '%' . $search . '%');
            });
        }

        $units = $query->orderBy('nama_unit')->get();
        return view('admin-spmi.unit-print', compact('units', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'deskripsi_unit' => 'nullable|string',
            'email_unit' => 'required|email|unique:unit_layanans,email_unit',
        ]);

        UnitLayanan::create($request->all());

        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $unit = UnitLayanan::findOrFail($id);

        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'deskripsi_unit' => 'nullable|string',
            'email_unit' => 'required|email|unique:unit_layanans,email_unit,'.$id,
        ]);

        $unit->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $unit = UnitLayanan::findOrFail($id);
        $unit->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
