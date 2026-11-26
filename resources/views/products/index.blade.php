@extends('layouts.app')

@section('title', ($isTrashed ? 'Sampah Produk' : 'Katalog Produk') . ' - Tepi Kebun')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-2">
    <div>
        <h2 class="tk-title mb-0">{{ $isTrashed ? 'Sampah Produk' : 'Katalog Produk Buah' }}</h2>
        <div class="tk-title-underline"></div>
    </div>
    <div class="d-flex gap-2">
        @if ($isTrashed)
            <a href="{{ route('products.index') }}" class="btn tk-btn-outline">&larr; Kembali ke Katalog</a>
        @else
            <a href="{{ route('products.trashed') }}" class="btn tk-btn-outline">Sampah</a>
            <a href="{{ route('products.create') }}" class="btn tk-btn-orange">+ Tambah Produk</a>
        @endif
    </div>
</div>

{{-- Ringkasan (hasil Collection di controller) --}}
@unless ($isTrashed)
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="tk-stat s1">
                <div class="num">{{ $stats['total'] }}</div>
                <div class="text-muted">Jenis produk
                    (A: {{ $stats['by_grade']->get('A', 0) }}, B: {{ $stats['by_grade']->get('B', 0) }})</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tk-stat s2">
                <div class="num">{{ number_format($stats['stock'], 0, ',', '.') }}</div>
                <div class="text-muted">Total stok (box)</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tk-stat s3">
                <div class="num">Rp {{ number_format($stats['avg_price'], 0, ',', '.') }}</div>
                <div class="text-muted">Rata-rata harga per box</div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-4">
        <div class="col-md-6">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                   placeholder="Cari nama atau kategori...">
        </div>
        <div class="col-md-3">
            <select name="grade" class="form-select">
                <option value="">Semua grade</option>
                <option value="A" @selected(request('grade') === 'A')>Grade A</option>
                <option value="B" @selected(request('grade') === 'B')>Grade B</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn tk-btn-green flex-fill" type="submit">Filter</button>
            <a href="{{ route('products.index') }}" class="btn tk-btn-outline">Reset</a>
        </div>
    </form>
@endunless

<div class="row g-4">
    @forelse ($products as $product)
        <div class="col-md-6 col-lg-4">
            <div class="card tk-card {{ $product->card_color }} h-100">
                <div class="card-body">
                    <span class="tk-badge {{ $product->grade === 'A' ? 'tk-badge-a' : 'tk-badge-b' }} mb-2">
                        Grade {{ $product->grade }}
                    </span>
                    <h5 class="card-title fw-bold">{{ $product->product_name }}</h5>
                    <p class="text-muted small mb-2">{{ $product->category }}</p>
                    <p class="fw-bold mb-1">{{ $product->formatted_price }}
                        <span class="text-muted small fw-normal">/ box ({{ $product->weight_per_box }} kg)</span>
                    </p>
                    <p class="small mb-0">Stok {{ $product->stock }} box &middot; Kematangan {{ $product->ripeness_percentage }}%</p>
                </div>
                <div class="card-footer bg-white border-0 pb-3 d-flex flex-wrap gap-2">
                    @if ($isTrashed)
                        @include('partials.restore-form', ['action' => route('products.restore', $product->id)])
                    @else
                        <a href="{{ route('products.show', $product) }}" class="btn tk-btn-outline btn-sm">Detail</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                        @include('partials.delete-form', ['action' => route('products.destroy', $product)])
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-light border text-center mb-0">
                {{ $isTrashed ? 'Sampah kosong.' : 'Belum ada produk yang sesuai.' }}
            </div>
        </div>
    @endforelse
</div>
@endsection
