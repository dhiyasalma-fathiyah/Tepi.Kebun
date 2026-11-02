<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tepi Kebun')</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/tepikebun.css') }}" rel="stylesheet">
</head>
<body>
 
<nav class="navbar navbar-expand-lg tk-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand tk-brand" href="{{ route('home') }}">
            <i class="bi bi-flower1"></i> Tepi Kebun
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto gap-lg-1">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('product') ? 'active' : '' }}" href="{{ route('product') }}">Produk</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('team') ? 'active' : '' }}" href="{{ route('team') }}">Tim</a></li>
                <li class="nav-item"><a class="btn tk-btn-orange ms-lg-2" href="{{ route('contact') }}">Hubungi Kami</a></li>
            </ul>
        </div>
    </div>
</nav>
 
<main class="py-5">
    <div class="container">
        @yield('content')
    </div>
</main>
 
<footer class="tk-footer py-4 mt-5">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <span><i class="bi bi-flower1"></i> Tepi Kebun &mdash; Pasokan buah segar untuk bisnis Anda</span>
        <span class="small">&copy; {{ date('Y') }} Tepi Kebun. All rights reserved.</span>
    </div>
</footer>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 
