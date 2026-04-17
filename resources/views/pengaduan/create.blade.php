@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2>Buat Pengaduan</h2>

    <form method="POST" action="{{ route('pengaduan.store') }}">
        @csrf

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Unit Tujuan</label>
            <input type="text" name="unit_tujuan" class="form-control">
        </div>

        <div class="mb-3">
            <label>Urgensi</label>
            <select name="urgensi" class="form-control">
                <option value="rendah">Rendah</option>
                <option value="sedang">Sedang</option>
                <option value="tinggi">Tinggi</option>
            </select>
        </div>

        <button class="btn btn-success">Kirim</button>
    </form>

</div>
@endsection