@extends('layouts.admin')

@php $isEdit = $member->exists; @endphp

@section('title', $isEdit ? 'Edit Anggota' : 'Tambah Anggota')
@section('heading', $isEdit ? 'Edit Anggota Tim' : 'Tambah Anggota Tim')

@section('content')
<div class="row"><div class="col-lg-6">
    <div class="tk-panel">
        <form action="{{ $isEdit ? route('admin.team.update', $member) : route('admin.team.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @if ($isEdit) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label" for="name">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $member->name) }}" class="form-control @error('name') is-invalid @enderror">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="role">Peran</label>
                <input type="text" id="role" name="role" value="{{ old('role', $member->role) }}" class="form-control @error('role') is-invalid @enderror">
                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="bio">Bio / NIM</label>
                <textarea id="bio" name="bio" rows="3" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $member->bio) }}</textarea>
                @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="photo">Foto</label>
                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp" class="form-control @error('photo') is-invalid @enderror">
                @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="form-text">JPG, PNG, atau WEBP. Maks 2 MB.</div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn tk-btn-green"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('admin.team.index') }}" class="btn tk-btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div></div>
@endsection
