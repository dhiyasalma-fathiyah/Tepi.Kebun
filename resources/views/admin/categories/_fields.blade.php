<div class="mb-3 mt-2">
    <label class="form-label" for="name">Nama kategori</label>
    <input type="text" id="name" name="name" value="{{ old('name', $category?->name) }}" class="form-control @error('name') is-invalid @enderror">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="icon">Ikon (emoji)</label>
    <input type="text" id="icon" name="icon" value="{{ old('icon', $category?->icon ?? '🍎') }}" maxlength="8" class="form-control @error('icon') is-invalid @enderror">
    @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div>
    <label class="form-label" for="description">Deskripsi</label>
    <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $category?->description) }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
