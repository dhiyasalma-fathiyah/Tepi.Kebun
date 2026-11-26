@extends('layouts.admin')

@section('title', 'Data Buah')
@section('heading', 'Data Buah')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link {{ ! $trashed ? 'active' : '' }}" href="{{ route('admin.products.index') }}">Aktif</a></li>
        <li class="nav-item"><a class="nav-link {{ $trashed ? 'active' : '' }}" href="{{ route('admin.products.index', ['trashed' => 1]) }}">Terhapus <span class="badge bg-secondary">{{ $trashedCount }}</span></a></li>
    </ul>
    <div class="d-flex gap-2">
        <form class="d-flex gap-2" method="GET">
            @if ($trashed) <input type="hidden" name="trashed" value="1"> @endif
            <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama buah...">
            <button class="btn btn-outline-success"><i class="bi bi-search"></i></button>
        </form>
        <a href="{{ route('admin.products.create') }}" class="btn tk-btn-green text-nowrap"><i class="bi bi-plus-lg"></i> Tambah</a>
    </div>
</div>

<div class="tk-panel p-0">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Produk</th><th>Kategori</th><th>Grade</th><th class="text-end">Harga / box</th><th class="text-center">Stok</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <x-product-image :product="$product" ratio="1x1" class="tk-thumb" />
                            <div><div class="fw-bold">{{ $product->product_name }}</div><div class="small text-muted">{{ $product->ripeness_percentage }}% &middot; {{ $product->weight_per_box }} kg</div></div>
                        </div>
                    </td>
                    <td>{{ $product->category->name }}</td>
                    <td><span class="tk-badge {{ $product->grade === 'A' ? 'tk-badge-a' : 'tk-badge-b' }}">{{ $product->grade }}</span></td>
                    <td class="text-end">@rupiah($product->price_per_box)</td>
                    <td class="text-center">
                        <span class="tk-badge {{ $product->stock <= 30 ? 'tk-badge-low' : 'tk-badge-stock' }}">{{ $product->stock }}</span>
                    </td>
                    <td class="text-end text-nowrap">
                        @if ($trashed)
                            <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="d-inline">@csrf
                                <button class="btn btn-sm btn-outline-success"><i class="bi bi-arrow-counterclockwise"></i> Pulihkan</button>
                            </form>
                        @else
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus {{ e($product->product_name) }}? Data dapat dipulihkan dari tab Terhapus.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection
