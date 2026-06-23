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
        $units = UnitLayanan::latest()->get();
        return view('admin-spmi.kelola-unit', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'deskripsi_unit' => 'nullable|string',
            'email_unit' => 'required|email|unique:unit_layanans,email_unit',
        ]);

        UnitLayanan::create($request->all());

        return redirect()->back()->with('success', 'Berhasil!Data unit layanan berhasil ditambahkan.');
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

        return redirect()->back()->with('warning', 'Berhasil Diperbarui!Data unit layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $unit = UnitLayanan::findOrFail($id);
        $unit->delete();

        return redirect()->back()->with('error', 'Berhasil Dihapus!Data unit layanan berhasil dihapus.');
    }
}
