@extends('layouts.app')

@section('title', 'Katalog Produk - Tepi Kebun')

@section('content')
<h2 class="fw-bold text-success mb-4">Katalog Produk Buah</h2>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <span class="badge bg-success mb-2">Grade A</span>
                <h5 class="card-title fw-bold">Pisang Cavendish</h5>
                <p class="card-text text-muted">Pisang kualitas superior, manis, dengan warna kuning cerah merata.</p>
            </div>
            <div class="card-footer bg-white border-0">
                <button class="btn btn-outline-success w-100">Detail Produk</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <span class="badge bg-success mb-2">Grade A</span>
                <h5 class="card-title fw-bold">Jeruk Siam</h5>
                <p class="card-text text-muted">Jeruk dengan kandungan air melimpah dan rasa manis segar alami.</p>
            </div>
            <div class="card-footer bg-white border-0">
                <button class="btn btn-outline-success w-100">Detail Produk</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <span class="badge bg-warning text-dark mb-2">Grade B</span>
                <h5 class="card-title fw-bold">Mangga Harum Manis</h5>
                <p class="card-text text-muted">Mangga manis aromatis, cocok untuk konsumsi langsung maupun olahan.</p>
            </div>
            <div class="card-footer bg-white border-0">
                <button class="btn btn-outline-success w-100">Detail Produk</button>
            </div>
        </div>
    </div>
</div>
@endsection