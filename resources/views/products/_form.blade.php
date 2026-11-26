{{-- Dipakai oleh create & edit. Variabel: $product --}}
<div class="row g-3">
    <div class="col-md-8">
        <label for="product_name" class="form-label fw-semibold">Nama Produk</label>
        <input type="text" name="product_name" id="product_name"
               value="{{ old('product_name', $product->product_name) }}"
               class="form-control @error('product_name') is-invalid @enderror">
        @error('product_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label for="grade" class="form-label fw-semibold">Grade</label>
        <select name="grade" id="grade" class="form-select @error('grade') is-invalid @enderror">
            <option value="">-- Pilih --</option>
            @foreach (['A', 'B'] as $g)
                <option value="{{ $g }}" @selected(old('grade', $product->grade) === $g)>Grade {{ $g }}</option>
            @endforeach
        </select>
        @error('grade') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="category" class="form-label fw-semibold">Kategori</label>
        <input type="text" name="category" id="category"
               value="{{ old('category', $product->category) }}" placeholder="Pisang, Jeruk, Mangga..."
               class="form-control @error('category') is-invalid @enderror">
        @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="ripeness_percentage" class="form-label fw-semibold">Tingkat Kematangan (%)</label>
        <input type="number" name="ripeness_percentage" id="ripeness_percentage" min="0" max="100"
               value="{{ old('ripeness_percentage', $product->ripeness_percentage) }}"
               class="form-control @error('ripeness_percentage') is-invalid @enderror">
        @error('ripeness_percentage') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label for="weight_per_box" class="form-label fw-semibold">Berat per Box (kg)</label>
        <input type="number" step="0.01" min="0" name="weight_per_box" id="weight_per_box"
               value="{{ old('weight_per_box', $product->weight_per_box) }}"
               class="form-control @error('weight_per_box') is-invalid @enderror">
        @error('weight_per_box') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label for="price_per_box" class="form-label fw-semibold">Harga per Box (Rp)</label>
        <input type="number" step="0.01" min="0" name="price_per_box" id="price_per_box"
               value="{{ old('price_per_box', $product->price_per_box) }}"
               class="form-control @error('price_per_box') is-invalid @enderror">
        @error('price_per_box') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label for="stock" class="form-label fw-semibold">Stok (box)</label>
        <input type="number" min="0" name="stock" id="stock"
               value="{{ old('stock', $product->stock ?? 0) }}"
               class="form-control @error('stock') is-invalid @enderror">
        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label for="image" class="form-label fw-semibold">URL Gambar <span class="text-muted fw-normal">(opsional)</span></label>
        <input type="text" name="image" id="image" value="{{ old('image', $product->image) }}"
               placeholder="https://..."
               class="form-control @error('image') is-invalid @enderror">
        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label fw-semibold">Deskripsi <span class="text-muted fw-normal">(opsional)</span></label>
        <textarea name="description" id="description" rows="3"
                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn tk-btn-green">Simpan</button>
    <a href="{{ route('products.index') }}" class="btn tk-btn-outline">Batal</a>
</div>
