@extends('layouts.app')
 
@section('title', 'Hubungi Kami - Tepi Kebun')
 
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="text-center">
            <h2 class="tk-title">Hubungi Kami</h2>
            <div class="tk-title-underline"></div>
            <p class="text-muted mb-4">Ceritakan kebutuhan pasokan buah bisnis Anda, kami siap membantu.</p>
        </div>
 
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
 
        <div class="tk-form-card">
            <form action="{{ route('contact.send') }}" method="POST" novalidate>
                @csrf
 
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Lengkap / Nama Bisnis</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Masukkan nama Anda">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
 
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="nama@email.com">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
 
                <div class="mb-4">
                    <label for="message" class="form-label fw-semibold">Pesan / Pertanyaan</label>
                    <textarea name="message" id="message" rows="4"
                              class="form-control @error('message') is-invalid @enderror"
                              placeholder="Tuliskan kebutuhan pasokan buah Anda...">{{ old('message') }}</textarea>
                    @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
 
                <button type="submit" class="btn tk-btn-green w-100">Kirim Pesan</button>
            </form>
        </div>
    </div>
</div>
@endsection
 