<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TeamMemberController;
use Illuminate\Support\Facades\Route;

// Halaman statis
Route::view('/', 'welcome')->name('home');
Route::view('/about', 'about')->name('about');

// Alias URL lama
Route::redirect('/product', '/products');
Route::redirect('/team', '/team-members');

// Produk (CRUD + soft delete)
Route::get('products-trashed', [ProductController::class, 'trashed'])->name('products.trashed');
Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
Route::resource('products', ProductController::class);

// Tim (CRUD + soft delete)
Route::get('team-members-trashed', [TeamMemberController::class, 'trashed'])->name('team-members.trashed');
Route::post('team-members/{id}/restore', [TeamMemberController::class, 'restore'])->name('team-members.restore');
Route::resource('team-members', TeamMemberController::class)->except('show');

// Kontak: form publik + pengelolaan pesan masuk
Route::get('/contact-us', [ContactController::class, 'create'])->name('contact');
Route::get('contacts-trashed', [ContactController::class, 'trashed'])->name('contacts.trashed');
Route::post('contacts/{id}/restore', [ContactController::class, 'restore'])->name('contacts.restore');
Route::resource('contacts', ContactController::class)->except(['create', 'show']);
