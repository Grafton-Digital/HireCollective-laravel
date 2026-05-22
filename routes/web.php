<?php

use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EnquiryController as DashboardEnquiryController;
use App\Http\Controllers\Dashboard\ProductController as DashboardProductController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\HomepageController;
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

// Enquiry (public, rate-limited)
Route::get('/enquiry/confirmation', [EnquiryController::class, 'confirmation'])->name('enquiry.confirmation');
Route::get('/enquiry/{product}', [EnquiryController::class, 'create'])->name('enquiry.create');
Route::post('/enquiry', [EnquiryController::class, 'store'])->middleware('throttle:5,1')->name('enquiry.store');

// Static pages
Route::get('/page/{page:slug}', [PageController::class, 'show'])->name('pages.show');

// Boutique dashboard
Route::middleware(['auth', 'boutique_staff'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::get('/products', [DashboardProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [DashboardProductController::class, 'create'])->name('products.create');
    Route::post('/products', [DashboardProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [DashboardProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [DashboardProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [DashboardProductController::class, 'destroy'])->name('products.destroy');

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
