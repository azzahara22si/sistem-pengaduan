@extends('layouts.main-dashboard')

@section('title', 'Kelola User')

@push('styles')
<style>

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #0d2d6e;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-wrap {
        display: flex;
        align-items: center;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        height: 42px;
        background: #fff;
        padding-left: 15px;
        transition: all 0.3s;
    }

    .search-wrap:focus-within {
        border-color: #0d428e;
        box-shadow: 0 0 0 4px rgba(13, 66, 142, 0.05);
    }

    .search-wrap input {
        border: none;
        outline: none;
        padding: 0 10px;
        font-size: 13px;
        font-family: 'Poppins', sans-serif;
        width: 180px;
        color: #334155;
    }

    .search-wrap button {
        background: none;
        border: none;
        padding: 0 15px;
        cursor: pointer;
        color: #64748b;
    }

    .btn-tambah {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #0d428e;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 0 20px;
        height: 42px;
        font-size: 13px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-tambah:hover {
        background: #093470;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(13, 66, 142, 0.2);
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-aktif { background: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; }
    .status-aktif::before { content: ''; width: 6px; height: 6px; background: #22c55e; border-radius: 50%; }
    .status-nonaktif { background: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2; }
    .status-nonaktif::before { content: ''; width: 6px; height: 6px; background: #ef4444; border-radius: 50%; }

    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.4);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
        padding: 20px;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-overlay.show { display: flex; }

    .modal-box {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        width: 100%;
        max-width: 420px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        display: flex;
        flex-direction: column;
        gap: 20px;
        position: relative;
        animation: slideUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #f1f5f9;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }

    .modal-close:hover {
        background: #fee2e2;
        color: #ef4444;
        transform: rotate(90deg);
    }

    .modal-header {
        text-align: center;
        margin-bottom: 10px;
    }

    .modal-title {
        font-size: 20px;
        font-weight: 700;
        color: #0d2d6e;
    }

    .modal-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-label {
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        color: #94a3b8;
        font-size: 14px;
    }

    .modal-box input {
        width: 100%;
        height: 42px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 0 16px 0 44px;
        font-size: 13px;
        font-family: 'Poppins', sans-serif;
        outline: none;
        transition: all 0.2s;
        background: #f8fafc;
    }

    .modal-box input:focus {
        border-color: #0d428e;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(13, 66, 142, 0.1);
    }

    .radio-group {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-top: 5px;
    }

    .radio-option {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 12px 8px;
        background: #f1f5f9;
        border: 1.5px solid transparent;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
    }

    .radio-option i {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .radio-option input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .radio-option:has(input:checked) {
        background: #e0f2fe;
        border-color: #0d428e;
        color: #0d428e;
    }

    .btn-simpan {
        background: #0d428e;
        color: #fff;
        border: none;
        border-radius: 12px;
        height: 30px;
        min-height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 5px;
        transition: all 0.3s;
        box-shadow: 0 4px 6px -1px rgba(13, 66, 142, 0.2);
    }

    .btn-simpan:hover {
        background: #093470;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(13, 66, 142, 0.3);
    }

    .select-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 16px;
        cursor: pointer;
    }

    .select-custom:focus {
        border-color: #0d428e;
        background-color: #fff;
    }

    .select-custom option {
        padding: 10px;
        font-family: 'Poppins', sans-serif;

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: stretch;
            gap: 20px;
        }

        .header-right {
            flex-direction: column;
            align-items: stretch;
        }

        .search-wrap {
            width: 100% !important;
        }

        .search-wrap input {
            width: 100% !important;
            flex: 1;
        }

        .btn-tambah {
            width: 100%;
            justify-content: center;
        }

        .radio-group {
            grid-template-columns: 1fr;
        }

        .modal-box {
            width: 95% !important;
            padding: 25px 20px !important;
            margin: 20px !important;
        }
    }
</style>
@endpush

@section('content')

    <div class="page-header">
        <h2 class="page-title">Kelola User</h2>
        <div class="header-right">
            <div class="search-wrap">
                <input type="text" placeholder="Cari nama atau email...">
                <button><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <button class="btn-tambah" onclick="document.getElementById('modalTambah').classList.add('show')">
                <span>Tambah User</span>
                <span class="plus-icon">+</span>
            </button>
        </div>
    </div>

    <div class="table-card" style="overflow-x: auto;">
        <div style="min-width: 900px;">
            <table>
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Unit</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users ?? [] as $index => $user)
                <tr>
                    <td>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td style="font-weight: 600;">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{ $user->unit->nama_unit ?? '-' }}
                    </td>
                    <td>
                        <span style="text-transform: capitalize;">{{ $user->role }}</span>
                    </td>
                    <td>
                        <span class="status-badge {{ ($user->status ?? 'Aktif') === 'Aktif' ? 'status-aktif' : 'status-nonaktif' }}">
                            {{ $user->status ?? 'Aktif' }}
                        </span>
                    </td>
                    <td style="text-align: center;">

                        <button type="button" 
                                onclick="openEditModal({{ json_encode($user) }})"
                                style="background: none; border: none; color: #64748b; cursor: pointer; margin: 0 5px;">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>

                        <button type="button" 
                                onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')"
                                style="background: none; border: none; color: #ef4444; cursor: pointer; margin: 0 5px;">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="modal-overlay {{ $errors->any() ? 'show' : '' }}" id="modalTambah" onclick="if(event.target===this) this.classList.remove('show')">
        <form action="{{ route('user.store') }}" method="POST" class="modal-box">
            @csrf
            <button type="button" class="modal-close" onclick="document.getElementById('modalTambah').classList.remove('show')">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="modal-header">
                <h3 class="modal-title">Tambah User Baru</h3>
                <p class="modal-subtitle">Silakan isi data user di bawah ini secara lengkap.</p>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-user-tag"></i> Nama Lengkap</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                </div>
                @error('name') <span style="color: #ef4444; font-size: 10px; margin-top: 4px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-envelope-open"></i> Alamat Email</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-at input-icon"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan alamat email" required>
                </div>
                @error('email') <span style="color: #ef4444; font-size: 10px; margin-top: 4px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-shield-halved"></i> Peran / Role</label>
                <div class="radio-group">
                    <label class="radio-option">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <input type="radio" name="role" value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'checked' : '' }} required onchange="toggleUnitField(this, 'unitFieldTambah')"> 
                        Mahasiswa
                    </label>
                    <label class="radio-option">
                        <i class="fa-solid fa-user-tie"></i>
                        <input type="radio" name="role" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }} onchange="toggleUnitField(this, 'unitFieldTambah')"> 
                        Admin Unit
                    </label>
                    <label class="radio-option">
                        <i class="fa-solid fa-user-shield"></i>
                        <input type="radio" name="role" value="admin_spmi" {{ old('role') == 'admin_spmi' ? 'checked' : '' }} onchange="toggleUnitField(this, 'unitFieldTambah')"> 
                        Admin SPMI
                    </label>
                </div>
                @error('role') <span style="color: #ef4444; font-size: 10px; margin-top: 4px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" id="unitFieldTambah" style="display: none;">
                <label class="form-label"><i class="fa-solid fa-building-circle-check"></i> Unit Layanan</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-building input-icon"></i>
                    <select name="unit_id" class="select-custom" style="padding: 0 40px 0 44px; width: 100%; height: 42px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-family: 'Poppins'; outline: none; background-color: #f8fafc; font-size: 13px; color: #334155; transition: all 0.2s;">
                        <option value="">Pilih Unit...</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>
                @error('unit_id') <span style="color: #ef4444; font-size: 10px; margin-top: 4px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-key"></i> Password</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="password" placeholder="Masukkan password awal" required>
                </div>
                @error('password') <span style="color: #ef4444; font-size: 10px; margin-top: 4px;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-simpan">
                <i class="fa-solid fa-user-plus" style="margin-right: 8px;"></i> Simpan Data User
            </button>
        </form>
    </div>

    <div class="modal-overlay" id="modalEdit" onclick="if(event.target===this) this.classList.remove('show')">
        <form id="formEdit" action="" method="POST" class="modal-box">
            @csrf
            @method('PUT')
            <button type="button" class="modal-close" onclick="document.getElementById('modalEdit').classList.remove('show')">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="modal-header">
                <h3 class="modal-title">Edit Data User</h3>
                <p class="modal-subtitle">Perbarui informasi user di bawah ini.</p>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-user-tag"></i> Nama Lengkap</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input type="text" name="name" id="edit_name" placeholder="Masukkan nama lengkap" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-envelope-open"></i> Alamat Email</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-at input-icon"></i>
                    <input type="email" name="email" id="edit_email" placeholder="Masukkan alamat email" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-shield-halved"></i> Peran / Role</label>
                <div class="radio-group">
                    <label class="radio-option">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <input type="radio" name="role" value="mahasiswa" id="edit_role_mahasiswa" required onchange="toggleUnitField(this, 'unitFieldEdit')"> 
                        Mahasiswa
                    </label>
                    <label class="radio-option">
                        <i class="fa-solid fa-user-tie"></i>
                        <input type="radio" name="role" value="admin" id="edit_role_admin" onchange="toggleUnitField(this, 'unitFieldEdit')"> 
                        Admin Unit
                    </label>
                    <label class="radio-option">
                        <i class="fa-solid fa-user-shield"></i>
                        <input type="radio" name="role" value="admin_spmi" id="edit_role_admin_spmi" onchange="toggleUnitField(this, 'unitFieldEdit')"> 
                        Admin SPMI
                    </label>
                </div>
            </div>

            <div class="form-group" id="unitFieldEdit" style="display: none;">
                <label class="form-label"><i class="fa-solid fa-building-circle-check"></i> Unit Layanan</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-building input-icon"></i>
                    <select name="unit_id" id="edit_unit_id" class="select-custom" style="padding: 0 40px 0 44px; width: 100%; height: 42px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-family: 'Poppins'; outline: none; background-color: #f8fafc; font-size: 13px; color: #334155; transition: all 0.2s;">
                        <option value="">Pilih Unit...</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-key"></i> Password (Kosongkan jika tidak diubah)</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="password" placeholder="Masukkan password baru">
                </div>
            </div>

            <button type="submit" class="btn-simpan">
                <i class="fa-solid fa-floppy-disk" style="margin-right: 8px;"></i> Simpan Perubahan
            </button>
        </form>
    </div>

    <div class="modal-overlay" id="modalDelete" onclick="if(event.target===this) this.classList.remove('show')">
        <div class="modal-box" style="width: 400px; text-align: center; padding: 45px 30px;">
            <div style="background: #fee2e2; color: #ef4444; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 25px;">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="modal-title" style="margin-bottom: 10px;">Hapus User?</h3>
            <p id="delete_text" style="font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 30px;">
                Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.
            </p>

            <div style="display: flex; gap: 15px; justify-content: center;">
                <button type="button" 
                        onclick="document.getElementById('modalDelete').classList.remove('show')"
                        style="flex: 1; height: 48px; border-radius: 12px; border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                    Batal
                </button>
                <form id="formDelete" action="" method="POST" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            style="width: 100%; height: 48px; border-radius: 12px; border: none; background: #ef4444; color: #fff; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2);">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleUnitField(radio, fieldId) {
            const field = document.getElementById(fieldId);
            if (radio.value === 'admin') {
                field.style.display = 'flex';
                field.querySelector('select').required = true;
            } else {
                field.style.display = 'none';
                field.querySelector('select').required = false;
            }
        }

        function openEditModal(user) {
            const modal = document.getElementById('modalEdit');
            const form = document.getElementById('formEdit');
            form.action = `/user/${user.id}`;
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_email').value = user.email;

            const roleRadios = {
                'mahasiswa': document.getElementById('edit_role_mahasiswa'),
                'admin': document.getElementById('edit_role_admin'),
                'admin_spmi': document.getElementById('edit_role_admin_spmi')
            };

            if (roleRadios[user.role]) {
                roleRadios[user.role].checked = true;
                toggleUnitField(roleRadios[user.role], 'unitFieldEdit');
            }

            if (user.role === 'admin' && user.unit_id) {
                document.getElementById('edit_unit_id').value = user.unit_id;
            } else {
                document.getElementById('edit_unit_id').value = "";
            }

            modal.classList.add('show');
        }

        function openDeleteModal(id, name) {
            const modal = document.getElementById('modalDelete');
            const form = document.getElementById('formDelete');
            const text = document.getElementById('delete_text');

            form.action = `/user/${id}`;
            text.innerHTML = `Apakah Anda yakin ingin menghapus user <strong>${name}</strong>? <br> Tindakan ini tidak dapat dibatalkan.`;

            modal.classList.add('show');
        }
    </script>
    @endpush
@endsection