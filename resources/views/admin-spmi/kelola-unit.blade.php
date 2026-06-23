@extends('layouts.main-dashboard')

@section('title', 'Kelola Unit Layanan')

@push('styles')
<style>

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #0d2d6e;
    }

    .btn-create {
        background: #0d428e;
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
    }

    .btn-create:hover {
        background: #092d61;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 66, 142, 0.2);
    }

    .table-card {
        background: white;
        border-radius: 20px;
        padding: 0;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #f8fafc;
        padding: 18px 24px;
        text-align: left;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #f1f5f9;
    }

    td {
        padding: 18px 24px;
        font-size: 14px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }

    .unit-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .unit-icon {
        width: 40px;
        height: 40px;
        background: #e0e7ff;
        color: #4338ca;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }



    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(5px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.show { display: flex; animation: fadeIn 0.3s ease; }

    .modal-content {
        background: white;
        width: 100%;
        max-width: 500px;
        border-radius: 24px;
        padding: 35px;
        position: relative;
        animation: slideUp 0.4s ease;
    }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

    .modal-header {
        margin-bottom: 25px;
    }

    .modal-title {
        font-size: 20px;
        font-weight: 700;
        color: #0d2d6e;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s;
        outline: none;
    }

    .form-control:focus {
        border-color: #0d428e;
        box-shadow: 0 0 0 4px rgba(13, 66, 142, 0.1);
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .btn-create {
            width: 100%;
            justify-content: center;
        }

        .modal-content {
            width: 95% !important;
            padding: 25px 20px !important;
            margin: 15px;
        }

        th, td {
            padding: 12px 15px !important;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h2 class="page-title">Kelola Unit Layanan</h2>
    <button class="btn-create" onclick="openModal('modalCreate')">
        <i class="fa-solid fa-plus"></i> Tambah Unit
    </button>
</div>

<div class="table-card" style="overflow-x: auto;">
    <div style="min-width: 800px;">
        <table>
        <thead>
            <tr>
                <th>Unit</th>
                <th>Email</th>
                <th>Deskripsi</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($units as $unit)
            <tr>
                <td>
                    <div class="unit-info">
                        <div class="unit-icon">
                            <i class="fa-solid fa-building-user"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #0d2d6e;">{{ $unit->nama_unit }}</div>
                            <div style="font-size: 12px; color: #94a3b8;">ID: #UNT-{{ str_pad($unit->id, 3, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $unit->email_unit }}</td>
                <td style="max-width: 300px; color: #64748b; font-size: 13px;">{{ Str::limit($unit->deskripsi_unit, 100) }}</td>
                <td style="text-align: center;">
                    <button type="button" 
                            onclick="editUnit({{ $unit }})"
                            style="background: none; border: none; color: #64748b; cursor: pointer; margin: 0 5px;">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <button type="button" 
                            onclick="confirmDelete({{ $unit->id }})"
                            style="background: none; border: none; color: #ef4444; cursor: pointer; margin: 0 5px;">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">
                    <i class="fa-solid fa-folder-open" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                    Belum ada data unit layanan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>

<div id="modalCreate" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Unit Baru</h3>
        </div>
        <form action="{{ route('unit.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Unit</label>
                <input type="text" name="nama_unit" class="form-control" placeholder="Contoh: Sarpras" required>
            </div>
            <div class="form-group">
                <label>Email Unit</label>
                <input type="email" name="email_unit" class="form-control" placeholder="Contoh: sarpras@univ.ac.id" required>
            </div>
            <div class="form-group">
                <label>Deskripsi Unit</label>
                <textarea name="deskripsi_unit" class="form-control" rows="3" placeholder="Jelaskan tupoksi unit ini..."></textarea>
            </div>
            <div style="display: flex; gap: 12px; margin-top: 30px;">
                <button type="button" class="form-control" style="background: #f1f5f9; border: none; cursor: pointer;" onclick="closeModal('modalCreate')">Batal</button>
                <button type="submit" class="btn-create" style="flex: 1; justify-content: center;">Simpan Unit</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Edit Unit Layanan</h3>
        </div>
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nama Unit</label>
                <input type="text" name="nama_unit" id="edit_nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email Unit</label>
                <input type="email" name="email_unit" id="edit_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Deskripsi Unit</label>
                <textarea name="deskripsi_unit" id="edit_deskripsi" class="form-control" rows="3"></textarea>
            </div>
            <div style="display: flex; gap: 12px; margin-top: 30px;">
                <button type="button" class="form-control" style="background: #f1f5f9; border: none; cursor: pointer;" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn-create" style="flex: 1; justify-content: center;">Perbarui Unit</button>
            </div>
        </form>
    </div>
</div>

<div id="modalDelete" class="modal">
    <div class="modal-content" style="max-width: 400px; text-align: center;">
        <div style="width: 70px; height: 70px; background: #fff1f2; color: #be123c; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 20px;">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 class="modal-title" style="margin-bottom: 10px;">Hapus Unit Layanan?</h3>
        <p style="color: #64748b; font-size: 14px; line-height: 1.5;">Data unit layanan yang dihapus tidak dapat dikembalikan kembali.</p>

        <form id="formDelete" method="POST">
            @csrf
            @method('DELETE')
            <div style="display: flex; gap: 12px; margin-top: 30px;">
                <button type="button" class="form-control" style="background: #f1f5f9; border: none; cursor: pointer;" onclick="closeModal('modalDelete')">Batal</button>
                <button type="submit" class="btn-create" style="flex: 1; justify-content: center; background: #be123c;">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('show');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    function editUnit(unit) {
        document.getElementById('edit_nama').value = unit.nama_unit;
        document.getElementById('edit_email').value = unit.email_unit;
        document.getElementById('edit_deskripsi').value = unit.deskripsi_unit;
        document.getElementById('formEdit').action = `/unit/${unit.id}`;
        openModal('modalEdit');
    }

    function confirmDelete(id) {
        document.getElementById('formDelete').action = `/unit/${id}`;
        openModal('modalDelete');
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.classList.remove('show');
        }
    }
</script>
@endpush
@endsection
