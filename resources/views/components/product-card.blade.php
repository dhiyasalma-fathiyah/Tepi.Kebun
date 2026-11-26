@props(['product'])

<div class="tk-card">
    <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
        <x-product-image :product="$product" />
    </a>
    <div class="body">
        <div class="d-flex gap-1 flex-wrap mb-2">
            <span class="tk-badge {{ $product->grade === 'A' ? 'tk-badge-a' : 'tk-badge-b' }}">Grade {{ $product->grade }}</span>
            <span class="tk-badge tk-badge-stock">{{ $product->category->name }}</span>
        </div>
        <h6 class="fw-bold mb-1">{{ $product->product_name }}</h6>
        <div class="small text-muted mb-2">
            {{ $product->ripeness_percentage }}% siap pajang &middot; {{ rtrim(rtrim(number_format($product->weight_per_box, 1, ',', '.'), '0'), ',') }} kg/box
        </div>
        <div class="tk-price">@rupiah($product->price_per_box) <small>/ box</small></div>
    </div>
    <div class="foot d-flex gap-2">
        <a href="{{ route('products.show', $product) }}" class="btn tk-btn-outline flex-fill">Detail</a>
        @if ($product->stock > 0)
            <a href="{{ route('orders.create', ['produk' => $product->id]) }}" class="btn tk-btn-orange flex-fill">Pesan</a>
        @else
            <button class="btn btn-secondary flex-fill" disabled>Habis</button>
        @endif
    </div>
</div>
