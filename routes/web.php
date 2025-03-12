<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth.basic'])->group(function () { 
    Route::resource('books', BookController::class);
    Route::get('/search-books', [BookController::class, 'search'])->name('books.search');
    Route::get('/dashboard', [BookController::class, 'dashboard'])->name('dashboard');
});


