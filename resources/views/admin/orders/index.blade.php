@extends('layouts.admin')

@section('title', 'Pesanan')
@section('heading', 'Pesanan')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link {{ ! $trashed && ! $status ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">Semua <span class="badge bg-secondary">{{ $counts->sum() }}</span></a></li>
        @foreach (\App\Models\Order::STATUSES as $key => [$label])
            <li class="nav-item"><a class="nav-link {{ ! $trashed && $status === $key ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => $key]) }}">{{ $label }} <span class="badge bg-secondary">{{ $counts->get($key, 0) }}</span></a></li>
        @endforeach
        <li class="nav-item"><a class="nav-link {{ $trashed ? 'active' : '' }}" href="{{ route('admin.orders.index', ['trashed' => 1]) }}">Terhapus <span class="badge bg-secondary">{{ $trashedCount }}</span></a></li>
    </ul>
    <form class="d-flex gap-2" method="GET">
        @if ($status) <input type="hidden" name="status" value="{{ $status }}"> @endif
        @if ($trashed) <input type="hidden" name="trashed" value="1"> @endif
        <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Kode / nama pembeli">
        <button class="btn btn-outline-success"><i class="bi bi-search"></i></button>
    </form>
</div>

<div class="tk-panel p-0">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Kode</th><th>Pembeli</th><th>Tanggal</th><th class="text-center">Item</th><th class="text-end">Total</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td class="fw-bold">{{ $order->order_code }}</td>
                    <td>{{ $order->customer_name }}<div class="small text-muted">{{ $order->city }}</div></td>
                    <td class="small">{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td class="text-center">{{ $order->items_count }}</td>
                    <td class="text-end">@rupiah($order->total_amount)</td>
                    <td><span class="badge text-bg-{{ $order->status_color }}">{{ $order->status_label }}</span></td>
                    <td class="text-end text-nowrap">
                        @if ($trashed)
                            <form action="{{ route('admin.orders.restore', $order->id) }}" method="POST" class="d-inline">@csrf
                                <button class="btn btn-sm btn-outline-success"><i class="bi bi-arrow-counterclockwise"></i> Pulihkan</button>
                            </form>
                        @else
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Detail</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-5">Tidak ada pesanan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
