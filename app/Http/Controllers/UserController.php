<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UnitLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin_spmi');
    }

    public function index(Request $request)
    {
        $search = $request->query('search', '');
        
        $query = User::with('unit');
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('nim', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%')
                  ->orWhere('role', 'LIKE', '%' . $search . '%');
            });
        }
        
        $users = $query->paginate(15)->withQueryString();
        $units = UnitLayanan::all();

        return view('admin-spmi.kelola-user', compact('users', 'units', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:mahasiswa,admin,admin_spmi',
            'unit_id' => 'required_if:role,admin|nullable|exists:unit_layanans,id',
        ]);

        User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'unit_id' => $request->role === 'admin' ? $request->unit_id : null,
        ]);

        return redirect()->route('user.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:users,nim,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'role' => 'required|in:mahasiswa,admin,admin_spmi',
            'unit_id' => 'required_if:role,admin|nullable|exists:unit_layanans,id',
        ]);

        $data = [
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            'role' => $request->role,
            'unit_id' => $request->role === 'admin' ? $request->unit_id : null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus.');
    }
}
