@extends('layouts.app')

@section('title', 'Tentang Kami - Tepi Kebun')

@section('content')
<div class="row align-items-center g-4">
    <div class="col-md-6">
        <h2 class="tk-title">Tentang Tepi Kebun</h2>
        <div class="tk-title-underline"></div>
        <p class="lead">Tepi Kebun adalah penyedia pasokan buah-buahan segar terpercaya untuk supermarket, restoran, dan mitra B2B lainnya.</p>
        <p class="text-muted">Kami berkomitmen memberikan kualitas buah terbaik dengan rantai pasok yang efisien dan harga yang kompetitif langsung dari sumbernya.</p>
        <a href="{{ route('contact') }}" class="btn tk-btn-green mt-2">Jadi Mitra Kami</a>
    </div>
    <div class="col-md-6">
        <div class="tk-form-card">
            <h5><i class="bi bi-bullseye text-success"></i> Misi Kami</h5>
            <ul class="mb-0 text-muted">
                <li class="mb-2">Menyediakan buah berkualitas tinggi dengan berbagai grade.</li>
                <li class="mb-2">Mempermudah pemesanan dan pengiriman bagi mitra usaha.</li>
                <li>Mendukung keberlanjutan rantai pasok hasil pertanian lokal.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
