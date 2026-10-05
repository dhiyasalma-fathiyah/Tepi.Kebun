@extends('layouts.app')

@section('title', 'Tim Kami - Tepi Kebun')

@section('content')
<div class="text-center mb-5">
    <h2 class="fw-bold text-success">Tim Pengembang</h2>
    <p class="text-muted">Orang-orang di balik pengembangan proyek Tepi Kebun.</p>
</div>

<div class="row justify-content-center g-4">
    <div class="col-md-4">
        <div class="card text-center shadow-sm border-0 p-3">
            <div class="card-body">
                <h5 class="card-title fw-bold">Dhiya Salma Fathiyah</h5>
                <p class="card-text text-muted">NIM: 2410120007</p>
                <span class="badge bg-primary">Developer</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center shadow-sm border-0 p-3">
            <div class="card-body">
                <h5 class="card-title fw-bold">Muhammad Briliant</h5>
                <p class="card-text text-muted">NIM: 2410120009</p>
                <span class="badge bg-primary">Developer</span>
            </div>
        </div>
    </div>
</div>
@endsection