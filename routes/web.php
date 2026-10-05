<?php

use Illuminate\Support\Facades\Route;

// Home
Route::get('/', function () {
    return view('welcome');
});

// About & Team Group
Route::prefix('about')->group(function () {
    // URL: /about
    Route::get('/', function () {
        return view('about');
    });

    // URL: /about/team
    Route::get('/team', function () {
        return view('team');
    });
});

// Product
Route::get('/product/{name_product?}', function ($name_product = 'Semua Produk') {
    return view('product', ['name_product' => $name_product]);
});

// Contact Us
Route::get('/contact-us', function () {
    return view('contact-us');
});