<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::pattern('product', '[0-9]+');
Route::pattern('review', '[0-9]+');

Route::get('/', [PageController::class, 'home'])->name('home');
Route::redirect('/home', '/');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/brands/{brand?}', [PageController::class, 'brands'])->name('brands');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class)->except(['index', 'show']);
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('products.reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::get('/test', function () {
    return view('test');
})->name('test');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::resource('products', ProductController::class)->only(['index', 'show']);

require __DIR__.'/auth.php';
