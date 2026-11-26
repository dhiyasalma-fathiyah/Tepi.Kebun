@extends('layouts.app')

@section('title', 'Katalog Buah - Tepi Kebun')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-2">
    <div>
        <h2 class="tk-title mb-0">Katalog Buah</h2>
        <div class="tk-title-underline"></div>
    </div>
    <a href="{{ route('orders.create') }}" class="btn tk-btn-orange mb-3"><i class="bi bi-bag-check"></i> Form Pemesanan</a>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('products.index') }}" class="tk-form-card mb-4">
    <div class="row g-2 align-items-end">
        <div class="col-md-5">
            <label class="form-label" for="q">Cari buah</label>
            <input type="search" id="q" name="q" value="{{ $filters['search'] }}" class="form-control" placeholder="Pisang, jeruk, mangga...">
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label" for="grade">Grade</label>
            <select name="grade" id="grade" class="form-select">
                <option value="">Semua</option>
                <option value="A" @selected($filters['grade'] === 'A')>Grade A</option>
                <option value="B" @selected($filters['grade'] === 'B')>Grade B</option>
            </select>
        </div>
        <div class="col-6 col-md-4 d-flex gap-2">
            @if ($filters['categoryId']) <input type="hidden" name="kategori" value="{{ $filters['categoryId'] }}"> @endif
            <button class="btn tk-btn-green flex-fill"><i class="bi bi-search"></i> Cari</button>
            <a href="{{ route('products.index') }}" class="btn tk-btn-outline">Reset</a>
        </div>
    </div>
</form>

{{-- Chip kategori --}}
<div class="d-flex flex-wrap gap-2 mb-4">
    <a class="tk-chip {{ ! $filters['categoryId'] ? 'active' : '' }}" href="{{ route('products.index', array_filter(['q' => $filters['search'], 'grade' => $filters['grade']])) }}">Semua ({{ $totalAll }})</a>
    @foreach ($categories as $category)
        <a class="tk-chip {{ (int) $filters['categoryId'] === $category->id ? 'active' : '' }}"
           href="{{ route('products.index', array_filter(['kategori' => $category->id, 'q' => $filters['search'], 'grade' => $filters['grade']])) }}">
            {{ $category->icon }} {{ $category->name }} ({{ $category->products_total }})
        </a>
    @endforeach
</div>

<p class="text-muted small">Menampilkan <strong>{{ $products->count() }}</strong> dari {{ $totalAll }} produk.</p>

<div class="row g-4">
    @forelse ($products as $product)
        <div class="col-sm-6 col-lg-4 col-xl-3"><x-product-card :product="$product" /></div>
    @empty
        <div class="col-12">
            <div class="tk-form-card text-center py-5">
                <div style="font-size:3rem">🔍</div>
                <h5 class="justify-content-center">Buah tidak ditemukan</h5>
                <p class="text-muted">Coba ubah kata kunci atau reset filter.</p>
                <a href="{{ route('products.index') }}" class="btn tk-btn-green">Tampilkan semua</a>
            </div>
        </div>
    @endforelse
</div>
@endsection
