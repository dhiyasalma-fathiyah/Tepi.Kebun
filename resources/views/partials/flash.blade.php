@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        Terdapat {{ $errors->count() }} kesalahan pada isian formulir. Periksa kembali kolom yang ditandai.
    </div>
@endif
