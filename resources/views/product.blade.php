@extends('layouts.app')
 
@section('title', 'Katalog Produk - Tepi Kebun')
 
@section('content')
<h2 class="tk-title">Katalog Produk Buah</h2>
<div class="tk-title-underline"></div>
 
@if ($slug && !$selected)
    <div class="alert alert-warning">
        Produk "<strong>{{ $slug }}</strong>" tidak ditemukan.
        <a href="{{ route('product') }}" class="alert-link">Lihat semua produk</a>.
    </div>
@endif
 
@if ($selected)
    {{-- Halaman detail: /product/{slug} --}}
    <div class="card tk-card {{ $selected['color'] }} p-4 mb-4">
        <span class="tk-badge {{ $selected['grade'] === 'A' ? 'tk-badge-a' : 'tk-badge-b' }} mb-2" style="width:fit-content">
            Grade {{ $selected['grade'] }}
        </span>
        <h3 class="fw-bold">{{ $selected['name'] }}</h3>
        <p class="text-muted">{{ $selected['desc'] }}</p>
        <div class="d-flex gap-2">
            <a href="{{ route('contact') }}" class="btn tk-btn-orange">Minta Penawaran</a>
            <a href="{{ route('product') }}" class="btn tk-btn-outline">&larr; Semua Produk</a>
        </div>
    </div>
@endif
 
<div class="row g-4">
    @foreach ($products as $p)
        <div class="col-md-4">
            <div class="card tk-card {{ $p['color'] }} h-100">
                <div class="card-body">
                    <span class="tk-badge {{ $p['grade'] === 'A' ? 'tk-badge-a' : 'tk-badge-b' }} mb-2">
                        Grade {{ $p['grade'] }}
                    </span>
                    <h5 class="card-title fw-bold">{{ $p['name'] }}</h5>
                    <p class="card-text text-muted">{{ $p['desc'] }}</p>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <a href="{{ route('product', $p['slug']) }}" class="btn tk-btn-outline w-100">Detail Produk</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
 