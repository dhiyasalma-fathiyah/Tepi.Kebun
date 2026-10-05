@extends('layouts.app')

@section('title', 'Hubungi Kami - Tepi Kebun')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="fw-bold text-success mb-4 text-center">Hubungi Kami</h2>
        
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap / Nama Bisnis</label>
                <input type="text" class="form-control" id="name" placeholder="Masukkan nama Anda">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" class="form-control" id="email" placeholder="nama@email.com">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Pesan / Pertanyaan</label>
                <textarea class="form-control" id="message" rows="4" placeholder="Tuliskan kebutuhan pasokan buah Anda..."></textarea>
            </div>
            <button type="submit" class="btn btn-success w-100">Kirim Pesan</button>
        </form>
    </div>
</div>
@endsection