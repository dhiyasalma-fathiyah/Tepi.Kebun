@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('heading', 'Edit Kategori')

@section('content')
<div class="row"><div class="col-lg-5">
    <div class="tk-panel">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" novalidate>
            @csrf @method('PUT')
            @include('admin.categories._fields')
            <div class="d-flex gap-2 mt-3">
                <button class="btn tk-btn-green flex-fill">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="btn tk-btn-outline flex-fill">Batal</a>
            </div>
        </form>
    </div>
</div></div>
@endsection
