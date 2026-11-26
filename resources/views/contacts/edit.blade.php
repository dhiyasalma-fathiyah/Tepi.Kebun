@extends('layouts.app')

@section('title', 'Edit Pesan - Tepi Kebun')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="tk-title">Edit Pesan</h2>
        <div class="tk-title-underline"></div>
        <div class="tk-form-card">
            <form action="{{ route('contacts.update', $contact) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                @include('contacts._form')
                <div class="d-flex gap-2">
                    <button type="submit" class="btn tk-btn-green">Simpan</button>
                    <a href="{{ route('contacts.index') }}" class="btn tk-btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
