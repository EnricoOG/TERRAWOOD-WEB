<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PublicPageController;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\PartnerController;

use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminSalesController;


// ==========================================
// PILIHAN BAHASA WEBSITE
// ==========================================

Route::get('/language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['en', 'id', 'zh'], true), 404);

    session(['site_locale' => $locale]);

    return redirect()->back();
})->name('language.switch');


// ==========================================
// HALAMAN PUBLIK
// ==========================================

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/catalog', [CatalogController::class, 'index'])
    ->name('catalog.index');

Route::get('/catalog/{slug}', [CatalogController::class, 'show'])
    ->name('catalog.show');

// Redirect URL lama ke URL bahasa Inggris
Route::redirect('/katalog', '/catalog', 301);

Route::get('/katalog/{slug}', function (string $slug) {
    return redirect('/catalog/' . $slug, 301);
});

Route::redirect('/layanan', '/services', 301);
Route::redirect('/portofolio', '/portfolio', 301);
Route::redirect('/artikel', '/articles', 301);

Route::get('/artikel/{slug}', function (string $slug) {
    return redirect('/articles/' . $slug, 301);
});

// Services
Route::get('/services', [PublicPageController::class, 'services'])
    ->name('services.index');

// Portfolio
Route::get('/portfolio', [PublicPageController::class, 'portfolios'])
    ->name('portfolios.index');

// Articles
Route::get('/articles', [PublicPageController::class, 'articles'])
    ->name('articles.index');

Route::get('/articles/{slug}', [PublicPageController::class, 'showArticle'])
    ->name('articles.show');


// ==========================================
// AUTENTIKASI CUSTOMER DAN ADMIN
// ==========================================

// Register
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

// Login Google
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('google.callback');

// Pengisian negara setelah Google Login
Route::get('/auth/google/country', [AuthController::class, 'showGoogleCountry'])
    ->name('google.country');

Route::post('/auth/google/country', [AuthController::class, 'finishGoogleRegistration'])
    ->name('google.country.store');

// Login biasa
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ==========================================
// HALAMAN CUSTOMER
// ==========================================

Route::middleware(['auth', 'role:user'])
    ->prefix('account')
    ->name('account.')
    ->group(function () {

        Route::get('/', [AccountController::class, 'index'])
            ->name('index');

        // Checkout
        Route::get('/checkout/{slug}', [CustomerOrderController::class, 'create'])
            ->name('orders.create');

        Route::post('/checkout/{slug}', [CustomerOrderController::class, 'store'])
            ->name('orders.store');

        // Detail pesanan
        Route::get('/orders/{id}', [AccountController::class, 'showOrder'])
            ->whereNumber('id')
            ->name('orders.show');

        // Pembatalan pesanan
        Route::post('/orders/{id}/cancel', [CustomerOrderController::class, 'cancel'])
            ->whereNumber('id')
            ->name('orders.cancel');

        // Notifikasi
        Route::post('/notifications/{id}/read', [AccountController::class, 'readNotification'])
            ->name('notifications.read');

        Route::get('/notifications/status', [AccountController::class, 'notificationStatus'])
            ->name('notifications.status');
    });


// ==========================================
// HALAMAN ADMIN
// ==========================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Customer
        Route::get('/customers', [AdminCustomerController::class, 'index'])
            ->name('customers.index');

        // Sales
        Route::get('/sales', [AdminSalesController::class, 'index'])
            ->name('sales.index');

        Route::post('/sales', [AdminSalesController::class, 'store'])
            ->name('sales.store');

        Route::get('/sales/export', [AdminSalesController::class, 'export'])
            ->name('sales.export');

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // CRUD Produk
        Route::resource('products', ProductController::class);

        // CRUD Kategori
        Route::resource('categories', CategoryController::class);

        // CRUD Layanan
        Route::resource('services', ServiceController::class);

        // CRUD Artikel
        Route::resource('articles', ArticleController::class);

        // CRUD Portofolio
        Route::resource('portfolios', PortfolioController::class);

        // CRUD Mitra
        Route::resource('partners', PartnerController::class);

        // CRUD Testimoni
        Route::resource('testimonials', TestimonialController::class);

        // CRUD Pesanan
        Route::resource('orders', OrderController::class);
    });
