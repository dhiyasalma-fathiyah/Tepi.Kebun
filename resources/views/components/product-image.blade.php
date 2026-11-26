@props(['product', 'ratio' => '4x3'])

{{-- Foto produk; jika kosong / file hilang tampil fallback ikon kategori. --}}
<div {{ $attributes->class(['tk-img', 'ratio', 'ratio-'.$ratio]) }}>
    <div class="tk-img-fallback" aria-hidden="true">{{ $product->category->icon ?? '🍎' }}</div>
    @if ($product->image_url)
        <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" loading="lazy"
             onerror="this.remove()">
    @endif
</div>
