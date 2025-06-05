<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Models\Genre;


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Statiskās lapas
Route::get('/', fn() => Inertia::render('HomeView'))->name('home');
Route::get('/login', fn() => Inertia::render('Auth/Login'))->name('login');
Route::get('/reg', fn() => Inertia::render('Auth/Register'))->name('reg');
Route::get('/kabinets', fn() => Inertia::render('KabinetsView'))->name('kabinets');
Route::get('/gramatas', fn() => Inertia::render('GramatasView'))->name('gramatas');

// Grāmatu Vue skatījums
Route::get('/book/{id}', fn($id) => Inertia::render('Book', ['id' => $id]));

// API ceļi
Route::get('/books', [BookController::class, 'index']);
Route::get('/get/all/books', [BookController::class, 'get_all']);
Route::get('/books/{id}', [BookController::class, 'show']);

// Komentāri
Route::get('/books/{book}/comments', [CommentController::class, 'index']);
Route::post('/books/{book}/comments', [CommentController::class, 'store']);
Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

// Reitingi
Route::get('/books/{book}/ratings', [RatingController::class, 'index']);
Route::post('/books/{book}/ratings', [RatingController::class, 'store']);

// Laravel Breeze / Jetstream autentifikācija
require __DIR__.'/auth.php';

Route::get('/api/genres', fn() => Genre::all());
