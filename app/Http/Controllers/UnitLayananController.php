<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitLayanan;

class UnitLayananController extends Controller
{
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

        return redirect()->back()->with('success', 'Unit Layanan berhasil ditambahkan');
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

        return redirect()->back()->with('success', 'Unit Layanan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $unit = UnitLayanan::findOrFail($id);
        $unit->delete();

        return redirect()->back()->with('success', 'Unit Layanan berhasil dihapus');
    }
}
