@extends('layouts.admin')

@section('title', 'Kategori')
@section('heading', 'Kategori Buah')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="tk-panel">
            <h6>Tambah Kategori</h6>
            <form action="{{ route('admin.categories.store') }}" method="POST" novalidate>
                @csrf
                @include('admin.categories._fields', ['category' => null])
                <button class="btn tk-btn-green w-100 mt-3"><i class="bi bi-plus-lg"></i> Tambah</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="tk-panel p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Kategori</th><th class="text-center">Jumlah Produk</th><th class="text-end">Aksi</th></tr></thead>
                    <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td><span class="fs-4 me-2">{{ $category->icon }}</span><strong>{{ $category->name }}</strong><div class="small text-muted">{{ $category->description }}</div></td>
                            <td class="text-center">{{ $category->products_count }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus kategori {{ e($category->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" @disabled($category->products_count > 0) title="{{ $category->products_count > 0 ? 'Masih memiliki produk' : 'Hapus' }}"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
