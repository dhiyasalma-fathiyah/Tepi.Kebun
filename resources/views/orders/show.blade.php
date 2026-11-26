@extends('layouts.app')

@section('title', 'Pesanan '.$order->order_code.' - Tepi Kebun')

@section('content')
@php
    $flow = ['pending' => 'Pesanan Dibuat', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai'];
    $keys = array_keys($flow);
    $currentIndex = array_search($order->status, $keys, true);
@endphp

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="tk-form-card text-center mb-4">
            <div class="display-4 text-success"><i class="bi bi-check-circle-fill"></i></div>
            <h2 class="tk-title mb-1">Pesanan Berhasil Dibuat</h2>
            <p class="text-muted mb-2">Terima kasih, {{ $order->customer_name }}! Simpan kode pesanan Anda:</p>
            <div class="d-inline-block border border-2 border-success rounded-3 px-4 py-2 fw-bold fs-4 text-success">{{ $order->order_code }}</div>
            <div class="mt-3">
                <span class="badge text-bg-{{ $order->status_color }} fs-6">{{ $order->status_label }}</span>
            </div>

            @if ($order->status === 'cancelled')
                <div class="alert alert-danger mt-3 mb-0">Pesanan ini telah dibatalkan.</div>
            @else
                <div class="tk-steps">
                    @foreach ($flow as $key => $label)
                        <div class="tk-step {{ $currentIndex !== false && array_search($key, $keys, true) <= $currentIndex ? 'done' : '' }}">
                            <div class="dot"><i class="bi bi-check-lg"></i></div>{{ $label }}
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="row g-4">
            <div class="col-md-7">
                <div class="tk-form-card h-100">
                    <h5><i class="bi bi-bag text-success"></i> Detail Produk</h5>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead><tr><th>Produk</th><th class="text-center">Jml</th><th class="text-end">Subtotal</th></tr></thead>
                            <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}<div class="small text-muted">@rupiah($item->unit_price) / box</div></td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end fw-semibold">@rupiah($item->subtotal)</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr><td colspan="2" class="fw-bold">Total ({{ $summary['boxes'] }} box, {{ $summary['varieties'] }} jenis)</td>
                                    <td class="text-end fw-bold text-success fs-5">@rupiah($order->total_amount)</td></tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="tk-form-card mb-4">
                    <h5><i class="bi bi-geo-alt text-success"></i> Pengiriman</h5>
                    <div class="fw-bold">{{ $order->customer_name }}</div>
                    <div class="small text-muted">{{ $order->phone }}@if ($order->email) &middot; {{ $order->email }}@endif</div>
                    <div class="mt-2 small">{{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</div>
                    @if ($order->notes) <div class="mt-2 small fst-italic text-muted">&ldquo;{{ $order->notes }}&rdquo;</div> @endif
                </div>

                <div class="tk-form-card">
                    <h5><i class="bi bi-credit-card text-success"></i> Pembayaran</h5>
                    <div class="fw-bold mb-1">{{ $order->payment_label }}</div>
                    @if ($order->payment_method === 'transfer')
                        <div class="small text-muted">Transfer ke:</div>
                        <div class="fw-bold">{{ config('tepikebun.bank.name') }} {{ config('tepikebun.bank.account') }}</div>
                        <div class="small text-muted">a.n. {{ config('tepikebun.bank.holder') }}</div>
                    @else
                        <div class="small text-muted">Bayar tunai saat pesanan tiba.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2 justify-content-center mt-4">
            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn tk-btn-wa"><i class="bi bi-whatsapp"></i> Konfirmasi via WhatsApp</a>
            <a href="{{ route('orders.create') }}" class="btn tk-btn-outline">Pesan Lagi</a>
            <a href="{{ route('home') }}" class="btn tk-btn-outline">Ke Beranda</a>
        </div>
    </div>
</div>
@endsection
