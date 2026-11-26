<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/team', [PageController::class, 'team'])->name('team');

Route::get('/produk', [CatalogController::class, 'index'])->name('products.index');
Route::get('/produk/{product:slug}', [CatalogController::class, 'show'])->name('products.show');

// Form Pemesanan (terpisah dari Hubungi Kami)
Route::get('/pesan', [OrderController::class, 'create'])->name('orders.create');
Route::post('/pesan', [OrderController::class, 'store'])->name('orders.store');
Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');

// Form Hubungi Kami + FAQ
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Autentikasi admin
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Area admin — dilindungi route middleware `auth` + `is_admin`
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', Admin\ProductController::class)->except('show');
        Route::post('products/{id}/restore', [Admin\ProductController::class, 'restore'])->name('products.restore');

        Route::resource('categories', Admin\CategoryController::class)->except(['show', 'create']);

        Route::resource('orders', Admin\OrderController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::post('orders/{id}/restore', [Admin\OrderController::class, 'restore'])->name('orders.restore');

        Route::resource('contacts', Admin\ContactMessageController::class)
            ->parameters(['contacts' => 'contact'])
            ->only(['index', 'show', 'update', 'destroy']);
        Route::post('contacts/{id}/restore', [Admin\ContactMessageController::class, 'restore'])->name('contacts.restore');

        Route::resource('team', Admin\TeamMemberController::class)->except('show');
        Route::post('team/{id}/restore', [Admin\TeamMemberController::class, 'restore'])->name('team.restore');
    });
