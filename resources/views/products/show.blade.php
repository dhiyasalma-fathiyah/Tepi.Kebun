@extends('layouts.app')

@section('title', $product->product_name.' - Tepi Kebun')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Katalog</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index', ['kategori' => $product->category_id]) }}">{{ $product->category->name }}</a></li>
        <li class="breadcrumb-item active">{{ $product->product_name }}</li>
    </ol>
</nav>

<div class="row g-4">
    <div class="col-lg-6">
        <x-product-image :product="$product" ratio="4x3" class="rounded-4 shadow-sm" />
    </div>
    <div class="col-lg-6">
        <div class="d-flex gap-1 mb-2">
            <span class="tk-badge {{ $product->grade === 'A' ? 'tk-badge-a' : 'tk-badge-b' }}">Grade {{ $product->grade }}</span>
            <span class="tk-badge tk-badge-stock">{{ $product->category->icon }} {{ $product->category->name }}</span>
        </div>
        <h1 class="h2">{{ $product->product_name }}</h1>
        <div class="tk-price fs-3 mb-3">@rupiah($product->price_per_box) <small>/ box</small></div>
        <p class="text-muted">{{ $product->description ?: 'Belum ada deskripsi.' }}</p>

        <div class="row g-2 mb-4">
            <div class="col-4"><div class="tk-feature p-3 text-center"><div class="text-muted small">Kematangan</div><div class="fw-bold">{{ $product->ripeness_percentage }}%</div></div></div>
            <div class="col-4"><div class="tk-feature p-3 text-center"><div class="text-muted small">Berat / box</div><div class="fw-bold">{{ rtrim(rtrim(number_format($product->weight_per_box, 1, ',', '.'), '0'), ',') }} kg</div></div></div>
            <div class="col-4"><div class="tk-feature p-3 text-center"><div class="text-muted small">Stok</div><div class="fw-bold {{ $product->stock <= 30 ? 'text-danger' : '' }}">{{ $product->stock }} box</div></div></div>
        </div>

        @if ($product->stock > 0)
            <a href="{{ route('orders.create', ['produk' => $product->id]) }}" class="btn tk-btn-orange btn-lg"><i class="bi bi-bag-check"></i> Pesan Produk Ini</a>
        @else
            <button class="btn btn-secondary btn-lg" disabled>Stok habis</button>
        @endif
        <a href="{{ route('products.index') }}" class="btn tk-btn-outline btn-lg">&larr; Katalog</a>
    </div>
</div>

@if ($related->isNotEmpty())
    <h4 class="tk-title mt-5 fs-4">Buah Sekategori</h4>
    <div class="tk-title-underline"></div>
    <div class="row g-4">
        @foreach ($related as $item)
            <div class="col-sm-6 col-lg-4"><x-product-card :product="$item" /></div>
        @endforeach
    </div>
@endif
@endsection
