@extends('layouts.main-dashboard')

@section('title', 'Edit Pengaduan')

@push('styles')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .form-card {
        background: #fff;
        border-radius: clamp(12px, 2vw, 20px);
        padding: clamp(15px, 4vw, 40px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .form-header {
        margin-bottom: clamp(20px, 5vw, 30px);
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: clamp(15px, 3vw, 20px);
    }

    .form-title {
        font-size: clamp(18px, 5vw, 22px);
        font-weight: 700;
        color: #0d2d6e;
    }

    .form-group {
        margin-bottom: clamp(15px, 3vw, 20px);
    }

    .form-group label {
        display: block;
        font-size: clamp(11px, 2vw, 13px);
        font-weight: 600;
        color: #64748b;
        margin-bottom: clamp(6px, 1vw, 8px);
    }

    .form-control {
        width: 100%;
        padding: clamp(10px, 2vw, 12px) clamp(12px, 2vw, 16px);
        border: 1.5px solid #e2e8f0;
        border-radius: clamp(8px, 1.5vw, 12px);
        font-family: 'Poppins', sans-serif;
        font-size: clamp(12px, 2vw, 14px);
        color: #334155;
        outline: none;
        transition: all 0.3s;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .form-control:focus {
        border-color: #0d428e;
        box-shadow: 0 0 0 4px rgba(13, 66, 142, 0.1);
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right clamp(8px, 2vw, 16px) center;
        background-size: clamp(14px, 2vw, 16px);
        cursor: pointer;
        padding-right: clamp(30px, 5vw, 40px);
    }

    textarea.form-control {
        min-height: clamp(100px, 20vw, 120px);
        resize: vertical;
    }

    .btn-submit {
        background: #0d428e;
        color: #fff;
        border: none;
        border-radius: clamp(8px, 1.5vw, 12px);
        padding: clamp(10px, 2vw, 14px) clamp(20px, 5vw, 30px);
        font-size: clamp(12px, 2vw, 15px);
        font-weight: 700;
        cursor: pointer;
        width: 100%;
        margin-top: clamp(8px, 2vw, 10px);
        transition: all 0.3s;
        min-height: 44px;
    }

    .btn-submit:hover {
        background: #093470;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(13, 66, 142, 0.2);
    }

    @media (max-width: 768px) {
        .form-container {
            width: 100%;
        }

        .form-card {
            padding: clamp(12px, 3vw, 20px);
        }
    }

    @media (max-width: 640px) {
        .form-control {
            font-size: 16px;
        }

        select.form-control {
            padding-right: clamp(30px, 4vw, 35px);
        }

        .btn-submit {
            padding: 12px 20px;
            min-height: 48px;
            font-size: 14px;
        }
    }
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        width: 100%;
        margin-top: 10px;
        transition: all 0.3s;
    }

    .btn-submit:hover {
        background: #093470;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(13, 66, 142, 0.2);
    }

    .form-info {
        background: #eff6ff;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 25px;
        display: flex;
        gap: 12px;
        align-items: center;
        color: #1e40af;
        font-size: 13px;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-card">
        <div class="form-header">
            <h2 class="form-title">Edit Pengaduan</h2>
            <p style="color: #64748b; font-size: 13px; margin-top: 5px;">Perbarui data pengaduan sebelum diproses.</p>
        </div>

        <div class="form-info">
            <i class="fa-solid fa-circle-info" style="font-size: 18px;"></i>
            <span>Hanya pengaduan dengan status diajukan yang dapat diedit.</span>
        </div>

        <form method="POST" action="{{ route('pengaduan.update', $pengaduan->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Judul Pengaduan</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $pengaduan->judul) }}" placeholder="Contoh: AC Ruang Kelas Rusak" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-list" style="margin-right: 5px;"></i> Klasifikasi</label>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                    <label style="display: flex; align-items: center; padding: 14px 16px; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; font-weight: normal; transition: all 0.3s; background: #fff;" onchange="updateKlasifikasiStyle(this)" onclick="updateKlasifikasiStyle(this)">
                        <input type="radio" name="klasifikasi" value="pengaduan" required style="margin-right: 10px; cursor: pointer; accent-color: #0d428e;" {{ old('klasifikasi', $pengaduan->klasifikasi) === 'pengaduan' ? 'checked' : '' }}>
                        <span style="font-size: 13px; font-weight: 600; color: #334155;">
                            <i class="fa-solid fa-exclamation-circle" style="margin-right: 6px;"></i> Pengaduan
                        </span>
                    </label>
                    <label style="display: flex; align-items: center; padding: 14px 16px; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; font-weight: normal; transition: all 0.3s; background: #fff;" onchange="updateKlasifikasiStyle(this)" onclick="updateKlasifikasiStyle(this)">
                        <input type="radio" name="klasifikasi" value="aspirasi" style="margin-right: 10px; cursor: pointer; accent-color: #0d428e;" {{ old('klasifikasi', $pengaduan->klasifikasi) === 'aspirasi' ? 'checked' : '' }}>
                        <span style="font-size: 13px; font-weight: 600; color: #334155;">
                            <i class="fa-solid fa-lightbulb" style="margin-right: 6px;"></i> Aspirasi
                        </span>
                    </label>
                    <label style="display: flex; align-items: center; padding: 14px 16px; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; font-weight: normal; transition: all 0.3s; background: #fff;" onchange="updateKlasifikasiStyle(this)" onclick="updateKlasifikasiStyle(this)">
                        <input type="radio" name="klasifikasi" value="permintaan_informasi" style="margin-right: 10px; cursor: pointer; accent-color: #0d428e;" {{ old('klasifikasi', $pengaduan->klasifikasi) === 'permintaan_informasi' ? 'checked' : '' }}>
                        <span style="font-size: 13px; font-weight: 600; color: #334155;">
                            <i class="fa-solid fa-circle-info" style="margin-right: 6px;"></i> Informasi
                        </span>
                    </label>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label><i class="fa-solid fa-building" style="margin-right: 5px;"></i> Unit Tujuan</label>
                    <select name="unit_tujuan" class="form-control" required>
                        <option value="">-- Pilih Unit Tujuan --</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->nama_unit }}" {{ old('unit_tujuan', $pengaduan->unit_tujuan) === $unit->nama_unit ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fa-solid fa-triangle-exclamation" style="margin-right: 5px;"></i> Tingkat Urgensi</label>
                    <select name="urgensi" class="form-control" required>
                        <option value="rendah" {{ old('urgensi', $pengaduan->urgensi) === 'rendah' ? 'selected' : '' }}>Rendah (Informasi)</option>
                        <option value="sedang" {{ old('urgensi', $pengaduan->urgensi) === 'sedang' ? 'selected' : '' }}>Sedang (Perbaikan Biasa)</option>
                        <option value="tinggi" {{ old('urgensi', $pengaduan->urgensi) === 'tinggi' ? 'selected' : '' }}>Tinggi (Darurat/Kritis)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi Detail</label>
                <textarea name="deskripsi" class="form-control" placeholder="Jelaskan secara detail mengenai keluhan atau pengaduan Anda..." required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
            </div>

            <div class="form-group">
                <label>Bukti Foto (Opsional)</label>
                <div style="border: 2px dashed #e2e8f0; border-radius: 12px; padding: 20px; text-align: center; background: #f8fafc; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.borderColor='#0d428e'" onmouseout="this.style.borderColor='#e2e8f0'" onclick="document.getElementById('foto_input').click()">
                    <img id="foto_preview" src="{{ $pengaduan->foto ? route('pengaduan.foto', $pengaduan->id) : '' }}" alt="Preview bukti foto" style="{{ $pengaduan->foto ? 'display: block;' : 'display: none;' }} width: 100%; max-height: 220px; object-fit: contain; border-radius: 10px; margin-bottom: 12px;">
                    <i id="foto_icon" class="fa-solid fa-cloud-arrow-up" style="{{ $pengaduan->foto ? 'display: none;' : 'display: inline-block;' }} font-size: 30px; color: #94a3b8; margin-bottom: 10px;"></i>
                    <p id="foto_file_name" style="font-size: 13px; color: {{ $pengaduan->foto ? '#0d2d6e' : '#64748b' }}; margin: 0;">{{ $pengaduan->foto ? basename($pengaduan->foto) : 'Klik untuk mengunggah atau seret file ke sini' }}</p>
                    <p style="font-size: 11px; color: #94a3b8; margin-top: 5px;">PNG, JPG atau JPEG (Max. 2MB)</p>
                    <input type="file" name="foto" id="foto_input" accept="image/png,image/jpeg" style="display: none;" onchange="previewFoto(this)">
                </div>
                @if($pengaduan->foto)
                <p style="margin-top: 12px; font-size: 13px; color: #64748b;">Foto saat ini: <strong>{{ basename($pengaduan->foto) }}</strong></p>
                @endif
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-pen-to-square" style="margin-right: 8px;"></i> Perbarui Pengaduan
            </button>
        </form>
    </div>
</div>

<script>
    function previewFoto(input) {
        const file = input.files && input.files[0];
        const preview = document.getElementById('foto_preview');
        const icon = document.getElementById('foto_icon');
        const fileName = document.getElementById('foto_file_name');

        if (!file) {
            preview.style.display = 'none';
            preview.removeAttribute('src');
            icon.style.display = 'inline-block';
            fileName.innerText = 'Klik untuk mengunggah atau seret file ke sini';
            fileName.style.color = '#64748b';
            return;
        }

        fileName.innerText = file.name;
        fileName.style.color = '#0d2d6e';
        icon.style.display = 'none';
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }

    function updateKlasifikasiStyle(label) {
        document.querySelectorAll('input[name="klasifikasi"]').forEach(radio => {
            radio.parentElement.style.borderColor = '#e2e8f0';
            radio.parentElement.style.backgroundColor = '#fff';
            radio.parentElement.style.boxShadow = 'none';
        });
        const selectedLabel = document.querySelector('input[name="klasifikasi"]:checked')?.parentElement;
        if (selectedLabel) {
            selectedLabel.style.borderColor = '#0d428e';
            selectedLabel.style.backgroundColor = '#eff6ff';
            selectedLabel.style.boxShadow = '0 0 0 4px rgba(13, 66, 142, 0.1)';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateKlasifikasiStyle();
    });
    document.querySelectorAll('input[name="klasifikasi"]').forEach(radio => {
        radio.addEventListener('change', updateKlasifikasiStyle);
    });
</script>
@endsection
