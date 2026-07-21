<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BoutiqueApplicationController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\Dashboard\EnquiryController as DashboardEnquiryController;
use App\Http\Controllers\Dashboard\ProductController as DashboardProductController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\NewArrivalsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/boutiques', [BoutiqueController::class, 'index'])->name('boutiques.index');
Route::get('/boutiques/{boutique:slug}', [BoutiqueController::class, 'show'])->name('boutiques.show');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/boutiques/{boutique:slug}/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites.index');
Route::get('/new-arrivals', NewArrivalsController::class)->name('new-arrivals');

// Enquiry (public, rate-limited)
Route::get('/enquiry/confirmation', [EnquiryController::class, 'confirmation'])->name('enquiry.confirmation');
Route::get('/enquiry/{product}', [EnquiryController::class, 'create'])->name('enquiry.create');
Route::post('/enquiry', [EnquiryController::class, 'store'])->middleware('throttle:5,1')->name('enquiry.store');

// Static pages
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/page/{page:slug}', [PageController::class, 'show'])->name('pages.show');

// Boutique application (public, rate-limited)
Route::get('/boutique/apply', [BoutiqueApplicationController::class, 'create'])->name('boutique.application.create');
Route::post('/boutique/apply', [BoutiqueApplicationController::class, 'store'])->middleware('throttle:3,60')->name('boutique.application.store');
Route::get('/boutique/application/confirmation', [BoutiqueApplicationController::class, 'confirmation'])->name('boutique.application.confirmation');

// Boutique owner account
Route::middleware(['auth', 'boutique_owner'])->prefix('account')->name('account.')->group(function () {
    Route::get('/', fn () => redirect()->route('account.overview'));
    Route::get('/overview', [AccountController::class, 'overview'])->name('overview');
    Route::get('/boutique-info', [AccountController::class, 'boutiqueInfo'])->name('boutique-info');
    Route::get('/settings', [AccountController::class, 'settings'])->name('settings');
    Route::get('/help-support', [AccountController::class, 'helpSupport'])->name('help-support');
    Route::patch('/profile', [AccountController::class, 'update'])->name('update');
    Route::patch('/password', [AccountController::class, 'updatePassword'])->name('password.update');

    // Products
    Route::get('/products', [AccountController::class, 'products'])->name('products');
    Route::get('/products/create', [DashboardProductController::class, 'create'])->name('products.create');
    Route::post('/products', [DashboardProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [DashboardProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [DashboardProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [DashboardProductController::class, 'destroy'])->name('products.destroy');

    // Enquiries
    Route::get('/enquiries', [DashboardEnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('/enquiries/{enquiry}', [DashboardEnquiryController::class, 'show'])->name('enquiries.show');
    Route::patch('/enquiries/{enquiry}', [DashboardEnquiryController::class, 'update'])->name('enquiries.update');
});

// Auth profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
