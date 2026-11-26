@extends('layouts.admin')

@section('title', 'Pesanan '.$order->order_code)
@section('heading', 'Pesanan '.$order->order_code)

@section('content')
<a href="{{ route('admin.orders.index') }}" class="small text-decoration-none">&larr; Kembali ke daftar</a>

<div class="row g-4 mt-1">
    <div class="col-lg-8">
        <div class="tk-panel mb-4">
            <h6>Item Pesanan</h6>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Produk</th><th class="text-end">Harga</th><th class="text-center">Jumlah</th><th class="text-end">Subtotal</th></tr></thead>
                    <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td class="text-end">@rupiah($item->unit_price)</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end fw-semibold">@rupiah($item->subtotal)</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot><tr><td colspan="3" class="fw-bold text-end">Total</td><td class="text-end fw-bold fs-5 text-success">@rupiah($order->total_amount)</td></tr></tfoot>
                </table>
            </div>
        </div>

        <div class="tk-panel">
            <h6>Data Pengiriman</h6>
            <div class="fw-bold">{{ $order->customer_name }}</div>
            <div class="small text-muted mb-2">{{ $order->phone }}@if ($order->email) &middot; {{ $order->email }}@endif</div>
            <div>{{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</div>
            @if ($order->notes) <div class="mt-2 fst-italic text-muted">&ldquo;{{ $order->notes }}&rdquo;</div> @endif
        </div>
    </div>

    <div class="col-lg-4">
        <div class="tk-panel mb-4">
            <h6>Status</h6>
            <div class="mb-3"><span class="badge text-bg-{{ $order->status_color }} fs-6">{{ $order->status_label }}</span></div>

            @if ($order->status === 'cancelled')
                <div class="small text-muted">Pesanan dibatalkan (stok sudah dikembalikan).</div>
            @else
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf @method('PUT')
                    <label class="form-label" for="status">Ubah status</label>
                    <select name="status" id="status" class="form-select mb-2">
                        @foreach (\App\Models\Order::STATUSES as $key => [$label])
                            <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="form-text mb-2">Memilih "Dibatalkan" akan mengembalikan stok produk.</div>
                    <button class="btn tk-btn-green w-100">Simpan Status</button>
                </form>
            @endif
        </div>

        <div class="tk-panel">
            <h6>Pembayaran</h6>
            <div>{{ $order->payment_label }}</div>
            <div class="small text-muted">Dibuat {{ $order->created_at->format('d M Y H:i') }}</div>
            <hr>
            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Pindahkan pesanan ke daftar terhapus?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger w-100"><i class="bi bi-trash"></i> Hapus Pesanan</button>
            </form>
        </div>
    </div>
</div>
@endsection
