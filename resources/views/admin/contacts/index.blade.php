@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('heading', 'Pesan Masuk')

@section('content')
<ul class="nav nav-pills mb-3">
    <li class="nav-item"><a class="nav-link {{ ! $trashed ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">Kotak Masuk</a></li>
    <li class="nav-item"><a class="nav-link {{ $trashed ? 'active' : '' }}" href="{{ route('admin.contacts.index', ['trashed' => 1]) }}">Terhapus <span class="badge bg-secondary">{{ $trashedCount }}</span></a></li>
</ul>

<div class="tk-panel p-0">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Pengirim</th><th>Subjek</th><th>Diterima</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @forelse ($messages as $message)
                <tr class="{{ ! $message->is_read && ! $trashed ? 'table-warning' : '' }}">
                    <td><div class="{{ $message->is_read ? '' : 'fw-bold' }}">{{ $message->name }}</div><div class="small text-muted">{{ $message->email }}</div></td>
                    <td>{{ $message->subject }}<div class="small text-muted">{{ \Illuminate\Support\Str::limit($message->message, 70) }}</div></td>
                    <td class="small">{{ $message->created_at->diffForHumans() }}</td>
                    <td class="text-end text-nowrap">
                        @if ($trashed)
                            <form action="{{ route('admin.contacts.restore', $message->id) }}" method="POST" class="d-inline">@csrf
                                <button class="btn btn-sm btn-outline-success"><i class="bi bi-arrow-counterclockwise"></i> Pulihkan</button>
                            </form>
                        @else
                            <a href="{{ route('admin.contacts.show', $message) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Baca</a>
                            <form action="{{ route('admin.contacts.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesan ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-5">Tidak ada pesan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $messages->links() }}</div>
@endsection
