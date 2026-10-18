@extends('layouts.app')
 
@section('title', 'Tepi Kebun - Pasokan Buah Segar B2B')
 
@section('content')
<section class="tk-hero mb-5">
    <span class="tk-badge tk-badge-b mb-3">🍊 Langsung dari kebun</span>
    <h1 class="mb-3">Buah segar untuk bisnis Anda, dari tepi kebun.</h1>
    <p class="lead mb-4">
        Pasokan buah berkualitas untuk supermarket, restoran, hotel, dan mitra B2B lainnya
        dengan rantai pasok efisien dan harga kompetitif.
    </p>
    <a href="{{ route('product') }}" class="btn tk-btn-orange btn-lg me-2">Lihat Produk</a>
    <a href="{{ route('contact') }}" class="btn btn-light btn-lg rounded-pill fw-bold">Hubungi Kami</a>
</section>
 
<section class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="tk-stat s1">
            <div class="num">100%</div>
            <div class="text-muted">Buah segar pilihan</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="tk-stat s2">
            <div class="num">Grade A &amp; B</div>
            <div class="text-muted">Sesuai kebutuhan bisnis</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="tk-stat s3">
            <div class="num">B2B</div>
            <div class="text-muted">Pemesanan &amp; pengiriman mudah</div>
        </div>
    </div>
</section>
 
<section class="mb-5">
    <h2 class="tk-title">Buah Unggulan</h2>
    <div class="tk-title-underline"></div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card tk-card banana h-100 p-3">
                <div class="tk-fruit-icon mb-3">🍌</div>
                <h5 class="fw-bold">Pisang Cavendish</h5>
                <p class="text-muted mb-0">Manis, kuning cerah merata.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card tk-card orange h-100 p-3">
                <div class="tk-fruit-icon mb-3">🍊</div>
                <h5 class="fw-bold">Jeruk Siam</h5>
                <p class="text-muted mb-0">Juicy dan segar alami.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card tk-card mango h-100 p-3">
                <div class="tk-fruit-icon mb-3">🥭</div>
                <h5 class="fw-bold">Mangga Harum Manis</h5>
                <p class="text-muted mb-0">Aromatis, cocok untuk olahan.</p>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('product') }}" class="btn tk-btn-outline px-4">Semua Produk</a>
    </div>
</section>
@endsection
