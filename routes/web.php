<?php
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 
// Home: /
Route::get('/', function () {
    return view('welcome');
})->name('home');
 
// About: /about
Route::get('/about', function () {
    return view('about');
})->name('about');
 
// Team: /team
Route::get('/team', function () {
    return view('team');
})->name('team');
 
// Product: /product  atau  /product/pisang-cavendish
Route::get('/product/{slug?}', function ($slug = null) {
    $products = [
        ['slug' => 'pisang-cavendish', 'name' => 'Pisang Cavendish', 'grade' => 'A', 'color' => 'banana',
         'desc' => 'Pisang kualitas superior, manis, dengan warna kuning cerah merata.'],
        ['slug' => 'jeruk-siam', 'name' => 'Jeruk Siam', 'grade' => 'A', 'color' => 'orange',
         'desc' => 'Jeruk dengan kandungan air melimpah dan rasa manis segar alami.'],
        ['slug' => 'mangga-harum-manis', 'name' => 'Mangga Harum Manis', 'grade' => 'B', 'color' => 'mango',
         'desc' => 'Mangga manis aromatis, cocok untuk konsumsi langsung maupun olahan.'],
    ];
 
    $selected = collect($products)->firstWhere('slug', $slug);
 
    return view('product', [
        'products' => $products,
        'selected' => $selected,
        'slug'     => $slug,
    ]);
})->name('product');
 
// Contact Us: /contact-us
Route::get('/contact-us', function () {
    return view('contact-us');
})->name('contact');
 
Route::post('/contact-us', function (Request $request) {
    $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'required|email',
        'message' => 'required|string|max:2000',
    ]);
 
    // TODO: simpan ke database / kirim email di sini
 
    return redirect()->route('contact')
        ->with('success', 'Terima kasih! Pesan Anda sudah kami terima.');
})->name('contact.send');