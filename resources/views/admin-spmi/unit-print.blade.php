@extends('layouts.print')

@section('title', 'Daftar Unit Layanan')

@section('content')
    <div style="padding: 20px;">
        <h2 style="text-align:center; margin-bottom: 10px;">Daftar Unit Layanan</h2>
        @if(!empty($search))
            <p style="text-align:center; color:#6b7280;">Filter: "{{ $search }}"</p>
        @endif
        <table style="width:100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th style="border:1px solid #ddd; padding:8px;">No</th>
                    <th style="border:1px solid #ddd; padding:8px;">Nama Unit</th>
                    <th style="border:1px solid #ddd; padding:8px;">Email Unit</th>
                    <th style="border:1px solid #ddd; padding:8px;">Deskripsi</th>
                    <th style="border:1px solid #ddd; padding:8px;">Dibuat Pada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($units as $i => $unit)
                <tr>
                    <td style="border:1px solid #ddd; padding:8px;">{{ $i + 1 }}</td>
                    <td style="border:1px solid #ddd; padding:8px;">{{ $unit->nama_unit }}</td>
                    <td style="border:1px solid #ddd; padding:8px;">{{ $unit->email_unit }}</td>
                    <td style="border:1px solid #ddd; padding:8px;">{!! nl2br(e($unit->deskripsi_unit)) !!}</td>
                    <td style="border:1px solid #ddd; padding:8px; white-space:nowrap;">{{ $unit->created_at->format('d/m/Y H:i') }} WIB</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="text-align:center; margin-top:20px;">
            <button onclick="window.print()" style="padding:8px 14px; border-radius:8px; background:#0d428e; color:#fff; border:none; cursor:pointer;">Cetak</button>
        </div>
    </div>
@endsection