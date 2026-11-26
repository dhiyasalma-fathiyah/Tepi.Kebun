@extends('layouts.app')

@section('title', 'Edit Produk - Tepi Kebun')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h2 class="tk-title">Edit Produk</h2>
        <div class="tk-title-underline"></div>
        <div class="tk-form-card">
            <form action="{{ route('products.update', $product) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                @include('products._form')
            </form>
        </div>
    </div>
</div>
@endsection
