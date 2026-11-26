@extends('layouts.admin')

@php $isEdit = $product->exists; @endphp

@section('title', $isEdit ? 'Edit Buah' : 'Tambah Buah')
@section('heading', $isEdit ? 'Edit Buah: '.$product->product_name : 'Tambah Buah')

@section('content')
<form action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}"
      method="POST" enctype="multipart/form-data" novalidate>
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="tk-panel">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label" for="product_name">Nama produk</label>
                        <input type="text" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}"
                               class="form-control @error('product_name') is-invalid @enderror">
                        @error('product_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="category_id">Kategori</label>
                        <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">Pilih...</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((int) old('category_id', $product->category_id) === $category->id)>{{ $category->icon }} {{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="grade">Grade</label>
                        <select id="grade" name="grade" class="form-select @error('grade') is-invalid @enderror">
                            @foreach (['A', 'B'] as $g)
                                <option value="{{ $g }}" @selected(old('grade', $product->grade) === $g)>Grade {{ $g }}</option>
                            @endforeach
                        </select>
                        @error('grade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="ripeness_percentage">Kematangan (%)</label>
                        <input type="number" id="ripeness_percentage" name="ripeness_percentage" min="0" max="100"
                               value="{{ old('ripeness_percentage', $product->ripeness_percentage) }}"
                               class="form-control @error('ripeness_percentage') is-invalid @enderror">
                        @error('ripeness_percentage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="weight_per_box">Berat / box (kg)</label>
                        <input type="number" step="0.1" id="weight_per_box" name="weight_per_box"
                               value="{{ old('weight_per_box', $product->weight_per_box) }}"
                               class="form-control @error('weight_per_box') is-invalid @enderror">
                        @error('weight_per_box') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="price_per_box">Harga / box (Rp)</label>
                        <input type="number" step="1000" id="price_per_box" name="price_per_box"
                               value="{{ old('price_per_box', $product->price_per_box) }}"
                               class="form-control @error('price_per_box') is-invalid @enderror">
                        @error('price_per_box') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="stock">Stok (box)</label>
                        <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', $product->stock) }}"
                               class="form-control @error('stock') is-invalid @enderror">
                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="description">Deskripsi</label>
                        <textarea id="description" name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="tk-panel">
                <h6>Foto Buah</h6>
                @if ($isEdit)
                    <x-product-image :product="$product" class="rounded-3 mb-3" />
                @endif
                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
                       class="form-control @error('image') is-invalid @enderror">
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="form-text">JPG, PNG, atau WEBP. Maks 2 MB. Jika kosong, tampil ikon kategori.</div>
                <img id="preview" class="img-fluid rounded-3 mt-3 d-none" alt="Pratinjau">

                @if ($isEdit && $product->image)
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                        <label class="form-check-label" for="remove_image">Hapus foto saat ini</label>
                    </div>
                @endif
            </div>

            <div class="d-grid gap-2 mt-3">
                <button class="btn tk-btn-green"><i class="bi bi-save"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Produk' }}</button>
                <a href="{{ route('admin.products.index') }}" class="btn tk-btn-outline">Batal</a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('image').addEventListener('change', function () {
    const img = document.getElementById('preview');
    const file = this.files[0];
    if (!file) { img.classList.add('d-none'); return; }
    img.src = URL.createObjectURL(file);
    img.classList.remove('d-none');
});
</script>
@endpush
