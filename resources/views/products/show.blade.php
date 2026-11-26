@extends('layouts.app')

@section('title', $product->product_name . ' - Tepi Kebun')

@section('content')
<div class="card tk-card {{ $product->card_color }} p-4">
    <span class="tk-badge {{ $product->grade === 'A' ? 'tk-badge-a' : 'tk-badge-b' }} mb-2" style="width:fit-content">
        Grade {{ $product->grade }}
    </span>
    <h3 class="fw-bold">{{ $product->product_name }}</h3>
    <p class="text-muted">{{ $product->description ?: 'Belum ada deskripsi.' }}</p>

    <dl class="row mb-3">
        <dt class="col-sm-3">Kategori</dt><dd class="col-sm-9">{{ $product->category }}</dd>
        <dt class="col-sm-3">Kematangan</dt><dd class="col-sm-9">{{ $product->ripeness_percentage }}%</dd>
        <dt class="col-sm-3">Berat per box</dt><dd class="col-sm-9">{{ $product->weight_per_box }} kg</dd>
        <dt class="col-sm-3">Harga per box</dt><dd class="col-sm-9">{{ $product->formatted_price }}</dd>
        <dt class="col-sm-3">Stok</dt><dd class="col-sm-9">{{ $product->stock }} box</dd>
        <dt class="col-sm-3">Permintaan masuk</dt><dd class="col-sm-9">{{ $product->contacts_count }} pesan</dd>
    </dl>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('contact', ['product_id' => $product->id]) }}" class="btn tk-btn-orange">Minta Penawaran</a>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-secondary">Edit</a>
        @include('partials.delete-form', ['action' => route('products.destroy', $product)])
        <a href="{{ route('products.index') }}" class="btn tk-btn-outline">&larr; Semua Produk</a>
    </div>
</div>
@endsection
