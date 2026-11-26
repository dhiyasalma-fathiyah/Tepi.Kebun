{{-- Tombol hapus (soft delete). Param: $action, $label (opsional) --}}
<form action="{{ $action }}" method="POST" class="d-inline"
      onsubmit="return confirm('Pindahkan data ini ke sampah?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger btn-sm">{{ $label ?? 'Hapus' }}</button>
</form>
