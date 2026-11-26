@extends('layouts.app')

@section('title', ($isTrashed ? 'Sampah Pesan' : 'Pesan Masuk') . ' - Tepi Kebun')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
    <div>
        <h2 class="tk-title mb-0">{{ $isTrashed ? 'Sampah Pesan' : 'Pesan Masuk' }}</h2>
        <div class="tk-title-underline"></div>
    </div>
    <div class="d-flex gap-2">
        @if ($isTrashed)
            <a href="{{ route('contacts.index') }}" class="btn tk-btn-outline">&larr; Kembali</a>
        @else
            <a href="{{ route('contacts.trashed') }}" class="btn tk-btn-outline">Sampah</a>
        @endif
    </div>
</div>

<div class="table-responsive tk-form-card p-0">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th>Pengirim</th>
                <th>Produk</th>
                <th>Pesan</th>
                <th>Diterima</th>
                <th class="text-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($contacts as $contact)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $contact->name }}</div>
                        <div class="small text-muted">{{ $contact->email }}</div>
                    </td>
                    <td>{{ $contact->product?->product_name ?? '-' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($contact->message, 60) }}</td>
                    <td class="small">{{ $contact->created_at->format('d M Y H:i') }}</td>
                    <td class="text-end text-nowrap">
                        @if ($isTrashed)
                            @include('partials.restore-form', ['action' => route('contacts.restore', $contact->id)])
                        @else
                            <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                            @include('partials.delete-form', ['action' => route('contacts.destroy', $contact)])
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">
                    {{ $isTrashed ? 'Sampah kosong.' : 'Belum ada pesan masuk.' }}
                </td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
