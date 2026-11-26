<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tepi Kebun')</title>
    @include('partials.head')
</head>
<body>

<nav class="navbar navbar-expand-lg tk-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand tk-brand" href="{{ route('home') }}">
            <span class="mark"><i class="bi bi-flower1"></i></span> Tepi Kebun
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-label="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('team') ? 'active' : '' }}" href="{{ route('team') }}">Tim</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Hubungi Kami</a></li>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0"><a class="btn tk-btn-orange" href="{{ route('orders.create') }}"><i class="bi bi-bag-check"></i> Pesan Sekarang</a></li>
                <li class="nav-item ms-lg-1">
                    @auth
                        @if (auth()->user()->is_admin)
                            <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                        @endif
                    @else
                        <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-person-lock"></i> Admin</a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="py-4 py-lg-5">
    <div class="container">
        @include('partials.flash')
        @yield('content')
    </div>
</main>

<footer class="tk-footer py-5 mt-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-5">
                <div class="tk-brand text-white mb-2" style="color:#fff !important"><span class="mark"><i class="bi bi-flower1"></i></span> Tepi Kebun</div>
                <p class="small mb-0">Pasokan buah segar berkualitas untuk bisnis Anda &mdash; langsung dari kebun pilihan, tanpa perantara.</p>
            </div>
            <div class="col-6 col-md-3">
                <h6>Menu</h6>
                <ul class="list-unstyled small mb-0">
                    <li><a href="{{ route('products.index') }}">Katalog Buah</a></li>
                    <li><a href="{{ route('orders.create') }}">Form Pemesanan</a></li>
                    <li><a href="{{ route('contact') }}">Hubungi Kami &amp; FAQ</a></li>
                    <li><a href="{{ route('login') }}">Login Admin</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-4">
                <h6>Kontak</h6>
                <ul class="list-unstyled small mb-0">
                    <li><i class="bi bi-envelope"></i> {{ config('tepikebun.admin_email') }}</li>
                    <li><a href="{{ \App\Support\WhatsApp::link('Halo Tepi Kebun, saya ingin bertanya.') }}" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i> Chat WhatsApp</a></li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <div class="small text-center">&copy; {{ date('Y') }} Tepi Kebun. All rights reserved.</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
