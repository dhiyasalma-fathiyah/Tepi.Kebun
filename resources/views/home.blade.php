@extends('layouts.app')

@section('title', 'Tepi Kebun - Pasokan Buah Segar B2B')

@section('content')
{{-- Hero (mockup halaman 6: Kemitraan Jangka Panjang) --}}
<section class="tk-hero mb-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-7">
            <span class="tk-badge tk-badge-b mb-3">🍊 Langsung dari kebun</span>
            <h1 class="mb-3">Kemitraan Jangka Panjang untuk Bisnis Anda</h1>
            <p class="lead mb-4">Buah berkualitas, transparan, dan langsung dari kebun &mdash; tanpa perantara. Cocok untuk supermarket, restoran, hotel, dan katering.</p>
            <a href="{{ route('orders.create') }}" class="btn tk-btn-orange btn-lg me-2 mb-2"><i class="bi bi-bag-check"></i> Pesan Sekarang</a>
            <a href="{{ route('products.index') }}" class="btn btn-light btn-lg fw-bold mb-2" style="border-radius:12px">Lihat Katalog</a>
        </div>
        <div class="col-lg-5 d-none d-lg-block">
            <div class="tk-hero-fruits">
                @foreach ($featured->take(4) as $p)
                    <div class="f">{{ $p->category->icon }}<small>{{ $p->product_name }}</small></div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Statistik (hasil olahan Collection di controller) --}}
<section class="row g-3 mb-5">
    <div class="col-md-4"><div class="tk-feature text-center"><div class="tk-display fs-2 text-success">{{ $stats['varieties'] }}+</div><div class="text-muted fw-semibold">Varietas buah tersedia</div></div></div>
    <div class="col-md-4"><div class="tk-feature text-center"><div class="tk-display fs-2 text-success">{{ number_format($stats['totalStock'], 0, ',', '.') }}</div><div class="text-muted fw-semibold">Box siap kirim</div></div></div>
    <div class="col-md-4"><div class="tk-feature text-center"><div class="tk-display fs-2 text-success">{{ $stats['gradeA'] }}</div><div class="text-muted fw-semibold">Produk Grade A</div></div></div>
</section>

{{-- Kategori --}}
<section class="mb-5">
    <h2 class="tk-title">Jelajahi Kategori</h2>
    <div class="tk-title-underline"></div>
    <div class="d-flex flex-wrap gap-2">
        @foreach ($categories as $category)
            <a class="tk-chip" href="{{ route('products.index', ['kategori' => $category->id]) }}">
                {{ $category->icon }} {{ $category->name }} <span class="text-muted">({{ $category->products_count }})</span>
            </a>
        @endforeach
    </div>
</section>

{{-- Unggulan --}}
<section class="mb-5">
    <h2 class="tk-title">Buah Unggulan</h2>
    <div class="tk-title-underline"></div>
    <div class="row g-4">
        @foreach ($featured as $product)
            <div class="col-sm-6 col-lg-3"><x-product-card :product="$product" /></div>
        @endforeach
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('products.index') }}" class="btn tk-btn-outline px-4">Semua Produk <i class="bi bi-arrow-right"></i></a>
    </div>
</section>

{{-- Keunggulan (mockup halaman 6) --}}
<section>
    <h2 class="tk-title text-center">Kenapa Tepi Kebun?</h2>
    <div class="tk-title-underline"></div>
    <div class="row g-3">
        @foreach ([
            ['bi-shield-check', 'Kualitas Terjamin', 'Multi-grade & QC ketat sebelum dikirim.'],
            ['bi-diagram-3', 'Transaksi Langsung', 'Dari kebun ke bisnis Anda tanpa broker.'],
            ['bi-receipt', 'Pesanan Tercatat', 'Kode pesanan & ringkasan jelas setiap transaksi.'],
            ['bi-truck', 'Pengiriman Tepat Waktu', 'Jadwal pengiriman terukur ke seluruh kota tujuan.'],
            ['bi-calendar-check', 'Pembayaran Fleksibel', 'Transfer bank atau bayar di tempat.'],
            ['bi-people', 'Dukungan Tim', 'Siap membantu lewat WhatsApp & email.'],
        ] as [$icon, $title, $text])
            <div class="col-md-6 col-lg-4">
                <div class="tk-feature"><div class="ic"><i class="bi {{ $icon }}"></i></div><h6>{{ $title }}</h6><p class="text-muted small mb-0">{{ $text }}</p></div>
            </div>
        @endforeach
    </div>
</section>
@endsection
