{{-- Tombol pulihkan. Param: $action --}}
<form action="{{ $action }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn tk-btn-green btn-sm">Pulihkan</button>
</form>
