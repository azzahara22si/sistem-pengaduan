@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Dashboard Pengaduan</h2>

    <div class="row">

        <div class="col-md-3">
            <div class="card text-white bg-dark mb-3">
                <div class="card-body">
                    <h5>Total</h5>
                    <h2>{{ $total }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5>Menunggu</h5>
                    <h2>{{ $menunggu }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5>Diproses</h5>
                    <h2>{{ $diproses }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5>Selesai</h5>
                    <h2>{{ $selesai }}</h2>
                </div>
            </div>
        </div>

    </div>

    <a href="/pengaduan" class="btn btn-secondary mt-3">Kembali</a>

</div>
@endsection