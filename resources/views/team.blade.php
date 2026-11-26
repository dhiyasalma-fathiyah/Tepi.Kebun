@extends('layouts.app')

@section('title', 'Tim Kami - Tepi Kebun')

@section('content')
<div class="text-center mb-5">
    <h2 class="tk-title">Tim Pengembang</h2>
    <div class="tk-title-underline"></div>
    <p class="text-muted">Orang-orang di balik pengembangan proyek Tepi Kebun.</p>
</div>

<div class="row justify-content-center g-4">
    @forelse ($members as $member)
        <div class="col-md-4">
            <div class="tk-card text-center p-4">
                <div class="tk-avatar">
                    @if ($member->photo_url)
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" onerror="this.remove()">
                    @else
                        {{ mb_strtoupper(mb_substr($member->name, 0, 1)) }}
                    @endif
                </div>
                <h5 class="fw-bold">{{ $member->name }}</h5>
                <p class="text-muted mb-2">{{ $member->bio }}</p>
                <span class="tk-badge tk-badge-a">{{ $member->role }}</span>
            </div>
        </div>
    @empty
        <p class="text-center text-muted">Belum ada anggota tim.</p>
    @endforelse
</div>
@endsection
