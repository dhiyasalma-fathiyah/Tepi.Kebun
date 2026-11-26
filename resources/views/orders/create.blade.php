@extends('layouts.app')

@section('title', 'Form Pemesanan - Tepi Kebun')

@section('content')
<h2 class="tk-title mb-0">Form Pemesanan</h2>
<div class="tk-title-underline"></div>

<form action="{{ route('orders.store') }}" method="POST" id="orderForm" novalidate>
    @csrf
    <div class="row g-4">
        {{-- Kolom kiri: produk + data pengiriman --}}
        <div class="col-lg-8">

            <div class="tk-form-card mb-4">
                <h5><i class="bi bi-basket3 text-success"></i> 1. Pilih Buah &amp; Jumlah (box)</h5>

                @error('items')
                    <div class="alert alert-danger py-2 small">{{ $message }}</div>
                @enderror

                @foreach ($grouped as $categoryName => $items)
                    <div class="fw-bold text-muted small text-uppercase mt-3 mb-2">{{ $items->first()->category->icon }} {{ $categoryName }}</div>
                    <div class="d-grid gap-2">
                        @foreach ($items as $product)
                            @php
                                $qty = (int) old('items.'.$product->id, $preselected === $product->id ? 1 : 0);
                            @endphp
                            <div class="tk-item-row {{ $qty > 0 ? 'selected' : '' }}"
                                 data-id="{{ $product->id }}" data-name="{{ $product->product_name }}"
                                 data-price="{{ $product->price_per_box }}" data-stock="{{ $product->stock }}">
                                <x-product-image :product="$product" ratio="1x1" class="thumb" />
                                <div class="flex-grow-1">
                                    <div class="fw-bold">{{ $product->product_name }}
                                        <span class="tk-badge {{ $product->grade === 'A' ? 'tk-badge-a' : 'tk-badge-b' }}">Grade {{ $product->grade }}</span>
                                    </div>
                                    <div class="tk-price">@rupiah($product->price_per_box) <small>/ box &middot; stok {{ $product->stock }}</small></div>
                                </div>
                                <div class="tk-qty">
                                    <button type="button" data-step="-1" aria-label="Kurangi">&minus;</button>
                                    <input type="number" class="qty" name="items[{{ $product->id }}]" value="{{ $qty }}"
                                           min="0" max="{{ $product->stock }}" aria-label="Jumlah {{ $product->product_name }}">
                                    <button type="button" data-step="1" aria-label="Tambah">+</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="tk-form-card mb-4">
                <h5><i class="bi bi-geo-alt text-success"></i> 2. Data Pembeli &amp; Alamat Pengiriman</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="customer_name" class="form-label">Nama pembeli / bisnis</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}"
                               class="form-control @error('customer_name') is-invalid @enderror" placeholder="Contoh: Toko Buah Segar">
                        @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Nomor telepon / WhatsApp</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                               class="form-control @error('phone') is-invalid @enderror" placeholder="081234567890">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">Email <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label for="address" class="form-label">Alamat lengkap</label>
                        <textarea id="address" name="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                  placeholder="Nama jalan, nomor, RT/RW, kelurahan, kecamatan">{{ old('address') }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-7">
                        <label for="city" class="form-label">Kota / Kabupaten</label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}"
                               class="form-control @error('city') is-invalid @enderror">
                        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-5">
                        <label for="postal_code" class="form-label">Kode pos</label>
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" inputmode="numeric" maxlength="5"
                               class="form-control @error('postal_code') is-invalid @enderror">
                        @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label for="notes" class="form-label">Catatan untuk penjual <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea id="notes" name="notes" rows="2" class="form-control @error('notes') is-invalid @enderror"
                                  placeholder="Contoh: kirim pagi hari, pisang jangan terlalu matang">{{ old('notes') }}</textarea>
                        @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="tk-form-card">
                <h5><i class="bi bi-credit-card text-success"></i> 3. Metode Pembayaran</h5>
                <div class="row g-2">
                    @foreach ($paymentMethods as $value => $label)
                        <div class="col-md-6">
                            <label class="tk-pay-option">
                                <input type="radio" class="form-check-input mt-0" name="payment_method" value="{{ $value }}"
                                       @checked(old('payment_method', 'transfer') === $value)>
                                <span class="fw-bold">{{ $label }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('payment_method') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Kolom kanan: ringkasan (sticky) --}}
        <div class="col-lg-4">
            <div class="tk-form-card tk-summary">
                <h5><i class="bi bi-receipt text-success"></i> Ringkasan Pesanan</h5>
                <div id="summaryLines" class="mb-1"></div>
                <div id="summaryEmpty" class="text-muted small py-3 text-center">Belum ada produk dipilih.</div>
                <div class="total"><span>Total</span><span id="grandTotal">Rp 0</span></div>
                <div class="text-muted small mt-1" id="totalBoxes">0 box</div>
                <button type="submit" id="submitBtn" class="btn tk-btn-orange w-100 mt-3 py-2" disabled>
                    <i class="bi bi-send"></i> Buat Pesanan
                </button>
                <p class="small text-muted mt-2 mb-0">Dengan memesan, Anda menyetujui syarat pengiriman Tepi Kebun.</p>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
(function () {
    const rows = document.querySelectorAll('.tk-item-row');
    const linesBox = document.getElementById('summaryLines');
    const emptyBox = document.getElementById('summaryEmpty');
    const totalEl = document.getElementById('grandTotal');
    const boxesEl = document.getElementById('totalBoxes');
    const submitBtn = document.getElementById('submitBtn');
    const rupiah = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');

    function clamp(input, row) {
        const max = parseInt(row.dataset.stock, 10);
        let v = parseInt(input.value, 10);
        if (isNaN(v) || v < 0) v = 0;
        if (v > max) v = max;
        input.value = v;
        return v;
    }

    function refresh() {
        let total = 0, boxes = 0;
        linesBox.innerHTML = '';
        rows.forEach(row => {
            const qty = clamp(row.querySelector('.qty'), row);
            row.classList.toggle('selected', qty > 0);
            if (qty === 0) return;
            const subtotal = qty * parseFloat(row.dataset.price);
            total += subtotal; boxes += qty;
            const line = document.createElement('div');
            line.className = 'line';
            const name = document.createElement('span');
            name.textContent = row.dataset.name + ' × ' + qty;
            const sub = document.createElement('strong');
            sub.textContent = rupiah(subtotal);
            line.append(name, sub);
            linesBox.appendChild(line);
        });
        emptyBox.style.display = boxes ? 'none' : 'block';
        totalEl.textContent = rupiah(total);
        boxesEl.textContent = boxes + ' box';
        submitBtn.disabled = boxes === 0;
    }

    rows.forEach(row => {
        const input = row.querySelector('.qty');
        row.querySelectorAll('[data-step]').forEach(btn => btn.addEventListener('click', () => {
            input.value = (parseInt(input.value, 10) || 0) + parseInt(btn.dataset.step, 10);
            refresh();
        }));
        input.addEventListener('input', refresh);
    });
    refresh();
})();
</script>
@endpush
