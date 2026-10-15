<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});

Route::get('/test', function () {
    return view('test');
})->name('test');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Oefenroute: activeer pas als TestController en de methode store bestaan.
// Route::post('/tests', [TestController::class, 'store'])->name('tests.store');

Route::resource('products', ProductController::class);

require __DIR__.'/auth.php';
