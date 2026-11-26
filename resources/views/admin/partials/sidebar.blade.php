<a class="tk-brand" href="{{ route('admin.dashboard') }}"><span class="mark"><i class="bi bi-flower1"></i></span> Tepi Kebun</a>

<nav class="flex-grow-1">
    <a class="tk-side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2"></i> Dashboard</a>

    <div class="tk-side-label">Katalog</div>
    <a class="tk-side-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="bi bi-basket3"></i> Data Buah</a>
    <a class="tk-side-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags"></i> Kategori</a>

    <div class="tk-side-label">Transaksi</div>
    <a class="tk-side-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
        <i class="bi bi-receipt"></i> Pesanan
        @if ($pendingOrders) <span class="badge bg-warning text-dark">{{ $pendingOrders }}</span> @endif
    </a>
    <a class="tk-side-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
        <i class="bi bi-envelope"></i> Pesan Masuk
        @if ($unread) <span class="badge bg-danger">{{ $unread }}</span> @endif
    </a>

    <div class="tk-side-label">Lainnya</div>
    <a class="tk-side-link {{ request()->routeIs('admin.team.*') ? 'active' : '' }}" href="{{ route('admin.team.index') }}"><i class="bi bi-people"></i> Tim</a>
    <a class="tk-side-link" href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Lihat Situs</a>
</nav>
