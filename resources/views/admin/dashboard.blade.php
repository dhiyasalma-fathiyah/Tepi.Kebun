@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3"><div class="tk-stat"><div class="d-flex justify-content-between"><div><div class="label">Total Pendapatan</div><div class="value">@rupiah($stats['revenue'])</div></div><div class="icon"><i class="bi bi-cash-stack"></i></div></div></div></div>
    <div class="col-6 col-xl-3"><div class="tk-stat orange"><div class="d-flex justify-content-between"><div><div class="label">Pesanan ({{ $stats['pending'] }} menunggu)</div><div class="value">{{ $stats['orders'] }}</div></div><div class="icon"><i class="bi bi-receipt"></i></div></div></div></div>
    <div class="col-6 col-xl-3"><div class="tk-stat"><div class="d-flex justify-content-between"><div><div class="label">Total Stok (box)</div><div class="value">{{ number_format($stats['stock'], 0, ',', '.') }}</div></div><div class="icon"><i class="bi bi-box-seam"></i></div></div></div></div>
    <div class="col-6 col-xl-3"><div class="tk-stat red"><div class="d-flex justify-content-between"><div><div class="label">Pesan Belum Dibaca</div><div class="value">{{ $stats['unread'] }}</div></div><div class="icon"><i class="bi bi-envelope-exclamation"></i></div></div></div></div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="tk-panel h-100">
            <h6 class="mb-3">Pendapatan 7 Hari Terakhir</h6>
            @php $max = max($revenueWeek->max(), 1); @endphp
            <div class="tk-bars">
                @foreach ($revenueWeek as $label => $value)
                    <div class="tk-bar" title="@rupiah($value)">
                        <span style="height: {{ round($value / $max * 100) }}%"></span>{{ $label }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="tk-panel h-100">
            <h6 class="mb-3">Pesanan per Status</h6>
            @foreach ($byStatus as $row)
                <div class="d-flex justify-content-between align-items-center py-1">
                    <span class="badge text-bg-{{ $row['color'] }}">{{ $row['label'] }}</span>
                    <strong>{{ $row['total'] }}</strong>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="tk-panel h-100">
            <h6 class="mb-3">Produk Terlaris (box)</h6>
            @forelse ($topProducts as $name => $total)
                <div class="d-flex justify-content-between border-bottom py-2"><span>{{ $name }}</span><strong>{{ $total }}</strong></div>
            @empty
                <p class="text-muted small mb-0">Belum ada penjualan.</p>
            @endforelse
        </div>
    </div>
    <div class="col-lg-4">
        <div class="tk-panel h-100">
            <h6 class="mb-3">Stok Menipis</h6>
            @forelse ($lowStock as $product)
                <div class="d-flex justify-content-between border-bottom py-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-decoration-none">{{ $product->product_name }}</a>
                    <span class="tk-badge tk-badge-low">{{ $product->stock }} box</span>
                </div>
            @empty
                <p class="text-muted small mb-0">Semua stok aman 👍</p>
            @endforelse
        </div>
    </div>
    <div class="col-lg-4">
        <div class="tk-panel h-100">
            <div class="d-flex justify-content-between mb-3"><h6 class="mb-0">Pesanan Terbaru</h6><a href="{{ route('admin.orders.index') }}" class="small">Semua</a></div>
            @forelse ($latestOrders as $order)
                <a href="{{ route('admin.orders.show', $order) }}" class="d-flex justify-content-between border-bottom py-2 text-decoration-none text-reset">
                    <span><strong>{{ $order->order_code }}</strong><br><small class="text-muted">{{ $order->customer_name }}</small></span>
                    <span class="text-end"><span class="badge text-bg-{{ $order->status_color }}">{{ $order->status_label }}</span><br><small>@rupiah($order->total_amount)</small></span>
                </a>
            @empty
                <p class="text-muted small mb-0">Belum ada pesanan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
