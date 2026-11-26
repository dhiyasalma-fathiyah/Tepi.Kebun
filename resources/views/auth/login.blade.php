<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Admin - Tepi Kebun</title>
    @include('partials.head')
</head>
<body>
<div class="tk-auth">
    <div class="tk-auth-side">
        <div class="tk-brand text-white mb-4" style="color:#fff !important"><span class="mark" style="background:var(--orange)"><i class="bi bi-flower1"></i></span> Tepi Kebun</div>
        <h1 class="display-6 mb-3">Solusi penjualan buah B2B, dari kebun ke bisnis Anda.</h1>
        <p class="opacity-75">Kelola katalog buah, stok, pesanan pelanggan, dan pesan masuk dalam satu dashboard.</p>
    </div>
    <div class="tk-auth-main">
        <div style="width:100%;max-width:380px">
            <a href="{{ route('home') }}" class="small text-decoration-none"><i class="bi bi-arrow-left"></i> Kembali ke situs</a>
            <h2 class="tk-title mt-3 mb-1">Masuk Akun Admin</h2>
            <p class="text-muted">Silakan login untuk mengakses dashboard operasional.</p>

            @include('partials.flash', ['hideErrorSummary' => true])

            <form action="{{ route('login.attempt') }}" method="POST" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" autofocus autocomplete="username"
                           class="form-control @error('email') is-invalid @enderror" placeholder="admin@tepikebun.test">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Kata sandi</label>
                    <input type="password" id="password" name="password" autocomplete="current-password"
                           class="form-control @error('password') is-invalid @enderror">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <button class="btn tk-btn-green w-100 py-2">Masuk</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
