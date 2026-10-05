<?php

use Illuminate\Support\Facades\Route;

// Home
Route::get('/', function () {
    return '<h1>Home Page</h1><p>Selamat datang di website kami!</p>';
});

// Group About & Our Team
Route::prefix('about')->group(function () {
    // URL: /about
    Route::get('/', function () {
        return '<h1>About Us</h1><p>Ini adalah halaman tentang perusahaan kami.</p>';
    });

    // URL: /about/team
    Route::get('/team', function () {
        return '<h1>Our Team</h1><p>Mengenal jajaran tim dan staf kami.</p>';
    });
});

// {Product}
Route::get('/product/{name_product?}', function ($name_product = 'Semua Produk') {
    return "<h1>Halaman Produk</h1><p>Menampilkan detail untuk produk: <strong>$name_product</strong></p>"
    . "<p>Lorem ipsum dolor sitam et, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>";
});

// Contact Us & Redirect
Route::get('/contact-us', function () {
    return '<h1>Contact Us</h1><p>Hubungi kami melalui email@example.com</p>';
});
Route::redirect('/contact', '/contact-us');

//tambahan buat /team
Route::redirect('/team', '/about/team');

// Fallback 
Route::fallback(function () {
    return '<h1>404 - Halaman Tidak Ditemukan</h1><p>Maaf, alamat URL yang kamu tuju tidak ada.</p>';
});

//-----------------------------------//
//-----------------------------------//

// Home
Route::get('/', function () {
    return view ('welcome');
});

Route::get('/about', function () {
    return view ('about');
});

Route::get('/contact-us', function () {
    return view ('contact-us');
});

Route::get('/product', function () {
    return view ('product');
});

Route::get('/team', function () {
    return view ('team');
});