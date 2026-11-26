@extends('layouts.app')

@section('title', 'Tambah Anggota Tim - Tepi Kebun')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <h2 class="tk-title">Tambah Anggota Tim</h2>
        <div class="tk-title-underline"></div>
        <div class="tk-form-card">
            <form action="{{ route('team-members.store') }}" method="POST" novalidate>
                @csrf
                @include('team-members._form')
            </form>
        </div>
    </div>
</div>
@endsection
