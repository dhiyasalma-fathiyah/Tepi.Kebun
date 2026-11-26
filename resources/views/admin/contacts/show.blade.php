@extends('layouts.admin')

@section('title', 'Pesan dari '.$contact->name)
@section('heading', 'Detail Pesan')

@section('content')
<a href="{{ route('admin.contacts.index') }}" class="small text-decoration-none">&larr; Kembali</a>
<div class="row mt-1"><div class="col-lg-8">
    <div class="tk-panel">
        <h5 class="fw-bold">{{ $contact->subject }}</h5>
        <div class="text-muted small mb-3">
            Dari <strong>{{ $contact->name }}</strong> &lt;{{ $contact->email }}&gt;@if ($contact->phone) &middot; {{ $contact->phone }}@endif
            &middot; {{ $contact->created_at->format('d M Y H:i') }}
        </div>
        <p style="white-space: pre-line">{{ $contact->message }}</p>
        <hr>
        <div class="d-flex flex-wrap gap-2">
            <a href="mailto:{{ $contact->email }}?subject={{ rawurlencode('Re: '.$contact->subject) }}" class="btn tk-btn-green"><i class="bi bi-reply"></i> Balas via Email</a>
            @if ($contact->phone)
                <a href="{{ \App\Support\WhatsApp::link('Halo '.$contact->name.', kami dari Tepi Kebun menindaklanjuti pesan Anda: '.$contact->subject) }}" target="_blank" rel="noopener" class="btn tk-btn-wa">
                    <i class="bi bi-whatsapp"></i> Balas via WhatsApp
                </a>
            @endif
            <form action="{{ route('admin.contacts.update', $contact) }}" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="is_read" value="0">
                <button class="btn tk-btn-outline">Tandai belum dibaca</button>
            </form>
        </div>
    </div>
</div></div>
@endsection
