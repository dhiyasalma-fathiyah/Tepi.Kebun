@extends('layouts.app')

@section('title', 'Tambah Produk - Tepi Kebun')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h2 class="tk-title">Tambah Produk</h2>
        <div class="tk-title-underline"></div>
        <div class="tk-form-card">
            <form action="{{ route('products.store') }}" method="POST" novalidate>
                @csrf
                @include('products._form')
            </form>
        </div>
    </div>
</div>
@endsection
