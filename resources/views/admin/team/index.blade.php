@extends('layouts.admin')

@section('title', 'Tim')
@section('heading', 'Anggota Tim')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link {{ ! $trashed ? 'active' : '' }}" href="{{ route('admin.team.index') }}">Aktif</a></li>
        <li class="nav-item"><a class="nav-link {{ $trashed ? 'active' : '' }}" href="{{ route('admin.team.index', ['trashed' => 1]) }}">Terhapus <span class="badge bg-secondary">{{ $trashedCount }}</span></a></li>
    </ul>
    <a href="{{ route('admin.team.create') }}" class="btn tk-btn-green"><i class="bi bi-plus-lg"></i> Tambah</a>
</div>

<div class="tk-panel p-0">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Nama</th><th>Peran</th><th>Bio</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="tk-avatar m-0" style="width:44px;height:44px;font-size:1.1rem">
                                @if ($member->photo_url)<img src="{{ $member->photo_url }}" alt="" onerror="this.remove()">@else{{ mb_strtoupper(mb_substr($member->name, 0, 1)) }}@endif
                            </div>
                            <strong>{{ $member->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $member->role }}</td>
                    <td class="text-muted small">{{ \Illuminate\Support\Str::limit($member->bio, 60) }}</td>
                    <td class="text-end text-nowrap">
                        @if ($trashed)
                            <form action="{{ route('admin.team.restore', $member->id) }}" method="POST" class="d-inline">@csrf
                                <button class="btn btn-sm btn-outline-success"><i class="bi bi-arrow-counterclockwise"></i> Pulihkan</button>
                            </form>
                        @else
                            <a href="{{ route('admin.team.edit', $member) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus {{ e($member->name) }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-5">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
