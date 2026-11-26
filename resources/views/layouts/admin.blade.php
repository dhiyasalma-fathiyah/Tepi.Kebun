<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - Tepi Kebun</title>
    @include('partials.head')
</head>
<body>
<div class="tk-admin">
    {{-- Sidebar desktop --}}
    <aside class="tk-sidebar">
        @include('admin.partials.sidebar')
    </aside>

    {{-- Sidebar mobile (offcanvas) --}}
    <div class="offcanvas offcanvas-start tk-sidebar" tabindex="-1" id="adminMenu">
        <div class="d-flex justify-content-end"><button class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Tutup"></button></div>
        @include('admin.partials.sidebar')
    </div>

    <div class="tk-admin-main">
        <header class="tk-topbar">
            <button class="btn btn-outline-secondary d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#adminMenu" aria-label="Menu"><i class="bi bi-list"></i></button>
            <h5 class="mb-0 fw-bold">@yield('heading')</h5>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="small text-muted d-none d-sm-inline"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                </form>
            </div>
        </header>

        <div class="tk-admin-content">
            @include('partials.flash')
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
