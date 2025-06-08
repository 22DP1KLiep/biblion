<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

// Kontrolieri
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Publiskās lapas (Vue)
Route::get('/', fn() => Inertia::render('HomeView'))->name('home');
Route::get('/gramatas', fn() => Inertia::render('GramatasView'))->name('gramatas');
Route::get('/book/{id}', fn($id) => Inertia::render('Book', ['id' => $id]))->name('book');
Route::get('/auth', fn() => Inertia::render('Auth/AuthForm'))->name('auth');
Route::get('/login', fn () => redirect('/auth')); // Pāradresācija

// Autentifikācija – reģistrācija un pieslēgšanās
Route::middleware('guest')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', fn() => Inertia::render('AdminPanelView'))->name('admin');
});

// Izrakstīšanās
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// API (publisks)
Route::get('/books', [BookController::class, 'index']);
Route::get('/get/all/books', [BookController::class, 'get_all']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/books/{book}/ratings', [RatingController::class, 'index']);
Route::get('/books/{book}/comments', [CommentController::class, 'index']);
Route::get('/api/genres', fn() => \App\Models\Genre::all());

// Kabinets – pieejams visiem (Vue pats parāda paziņojumu, ja nav ielogots)
Route::get('/kabinets', fn() => Inertia::render('KabinetsView'))->name('kabinets');

// Tikai autorizētiem lietotājiem
Route::middleware(['auth'])->group(function () {
    // Reitings
    Route::post('/books/{book}/ratings', [RatingController::class, 'store']);
    Route::get('/books/{book}/my-rating', [RatingController::class, 'show']);

    // Komentāri
    Route::post('/books/{book}/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

    // Mapes (folders)
    Route::get('/folders', [FolderController::class, 'index']);
    Route::post('/folders', [FolderController::class, 'store']);
    Route::get('/folders/{folder}/books', [FolderController::class, 'books']);
    Route::post('/folders/{folder}/books', [FolderController::class, 'addBook']);
    Route::delete('/folders/{folder}/books/{book}', [FolderController::class, 'removeBook']);
    Route::delete('/folders/{folder}', [FolderController::class, 'destroy']);
});
