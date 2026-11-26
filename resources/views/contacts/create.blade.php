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

        <div class="tk-form-card">
            <form action="{{ route('contacts.store') }}" method="POST" novalidate>
                @csrf
                @include('contacts._form')
                <button type="submit" class="btn tk-btn-green w-100">Kirim Pesan</button>
            </form>
        </div>
    </div>
</div>
@endsection
