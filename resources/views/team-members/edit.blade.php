@extends('layouts.app')

@section('title', 'Edit Anggota Tim - Tepi Kebun')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <h2 class="tk-title">Edit Anggota Tim</h2>
        <div class="tk-title-underline"></div>
        <div class="tk-form-card">
            <form action="{{ route('team-members.update', $teamMember) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                @include('team-members._form')
            </form>
        </div>
    </div>
</div>
@endsection
