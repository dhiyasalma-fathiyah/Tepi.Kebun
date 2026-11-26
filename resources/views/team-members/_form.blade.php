{{-- Dipakai oleh create & edit. Variabel: $teamMember --}}
<div class="mb-3">
    <label for="name" class="form-label fw-semibold">Nama</label>
    <input type="text" name="name" id="name" value="{{ old('name', $teamMember->name) }}"
           class="form-control @error('name') is-invalid @enderror">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="role" class="form-label fw-semibold">Peran</label>
    <input type="text" name="role" id="role" value="{{ old('role', $teamMember->role) }}"
           class="form-control @error('role') is-invalid @enderror">
    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="bio" class="form-label fw-semibold">Bio / NIM <span class="text-muted fw-normal">(opsional)</span></label>
    <textarea name="bio" id="bio" rows="3"
              class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $teamMember->bio) }}</textarea>
    @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="photo" class="form-label fw-semibold">URL Foto <span class="text-muted fw-normal">(opsional)</span></label>
    <input type="text" name="photo" id="photo" value="{{ old('photo', $teamMember->photo) }}" placeholder="https://..."
           class="form-control @error('photo') is-invalid @enderror">
    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn tk-btn-green">Simpan</button>
    <a href="{{ route('team-members.index') }}" class="btn tk-btn-outline">Batal</a>
</div>
