@extends('layouts.app')

@section('title', ($isTrashed ? 'Sampah Tim' : 'Tim Kami') . ' - Tepi Kebun')

@section('content')
@php($colors = ['strawberry', 'orange', 'banana', 'grape'])

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h2 class="tk-title mb-0">{{ $isTrashed ? 'Sampah Tim' : 'Tim Pengembang' }}</h2>
        <div class="tk-title-underline"></div>
        <p class="text-muted mb-0">Orang-orang di balik pengembangan proyek Tepi Kebun.</p>
    </div>
    <div class="d-flex gap-2">
        @if ($isTrashed)
            <a href="{{ route('team-members.index') }}" class="btn tk-btn-outline">&larr; Kembali</a>
        @else
            <a href="{{ route('team-members.trashed') }}" class="btn tk-btn-outline">Sampah</a>
            <a href="{{ route('team-members.create') }}" class="btn tk-btn-orange">+ Tambah Anggota</a>
        @endif
    </div>
</div>

<div class="row justify-content-center g-4">
    @forelse ($teamMembers as $member)
        <div class="col-md-4">
            <div class="card tk-card {{ $colors[$loop->index % count($colors)] }} text-center p-3 h-100">
                <div class="card-body">
                    <div class="tk-avatar av-{{ ($loop->index % 2) + 1 }}">{{ $member->initial }}</div>
                    <h5 class="card-title fw-bold">{{ $member->name }}</h5>
                    <p class="card-text text-muted">{{ $member->bio }}</p>
                    <span class="tk-badge tk-badge-role">{{ $member->role }}</span>
                </div>
                <div class="card-footer bg-transparent border-0 d-flex justify-content-center gap-2">
                    @if ($isTrashed)
                        @include('partials.restore-form', ['action' => route('team-members.restore', $member->id)])
                    @else
                        <a href="{{ route('team-members.edit', $member) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                        @include('partials.delete-form', ['action' => route('team-members.destroy', $member)])
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-light border text-center mb-0">
                {{ $isTrashed ? 'Sampah kosong.' : 'Belum ada anggota tim.' }}
            </div>
        </div>
    @endforelse
</div>
@endsection
