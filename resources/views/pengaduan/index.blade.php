@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Data Pengaduan</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol tambah (HANYA MAHASISWA) --}}
    @if(auth()->user()->isMahasiswa())
    <a href="{{ route('pengaduan.create') }}" class="btn btn-primary mb-3">
        + Buat Pengaduan
    </a>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Unit</th>
                <th>Urgensi</th>
                <th>Status</th>
                <th>Tanggapan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($pengaduans as $p)
            <tr>
                <td>{{ $p->judul }}</td>
                <td>{{ $p->deskripsi }}</td>
                <td>{{ $p->unit_tujuan }}</td>
                <td>{{ $p->urgensi }}</td>

                {{-- STATUS --}}
                <td>
                    <span class="badge bg-{{ 
                        $p->status == 'menunggu' ? 'warning' : 
                        ($p->status == 'proses' ? 'primary' : 'success') 
                    }}">
                        {{ $p->status }}
                    </span>
                </td>

                {{-- TANGGAPAN --}}
                <td>
                    @if($p->tanggapan->count() > 0)
                        @foreach($p->tanggapan as $t)
                            <div class="alert alert-info p-2 mb-1">
                                {{ $t->isi_tanggapan }}
                            </div>
                        @endforeach
                    @else
                        <span class="text-muted">Belum ada</span>
                    @endif
                </td>

                {{-- AKSI --}}
                <td>

                    {{-- PETUGAS & ADMIN BISA TANGGAPI --}}
                    @if(auth()->user()->isPetugas() || auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('tanggapan.store') }}">
                        @csrf
                        <input type="hidden" name="pengaduan_id" value="{{ $p->id }}">

                        <textarea name="isi_tanggapan" 
                                  class="form-control mb-2" 
                                  placeholder="Tulis tanggapan..." 
                                  required></textarea>

                        <button class="btn btn-primary btn-sm">Kirim</button>
                    </form>
                    @endif

                    {{-- ADMIN SAJA BISA HAPUS --}}
                    @if(auth()->user()->isAdmin())
                    <form action="{{ route('pengaduan.destroy', $p->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm mt-2">Hapus</button>
                    </form>
                    @endif

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada pengaduan</td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
@endsection