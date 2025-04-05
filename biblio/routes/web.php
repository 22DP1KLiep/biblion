<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('HomeView');
})->name('home');

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::get('/reg', function () {
    return Inertia::render('Auth/Register');
})->name('reg');

Route::get('/kabinets', function () {
    return Inertia::render('KabinetsView');
})->name('kabinets');

Route::get('/gramatas', function () {
    return Inertia::render('GramatasView');
})->name('gramatas');

//Route::get('/jaunumi', function () {
//    return Inertia::render('JaunumiView');
//})->name('jaunumi');


use App\Http\Controllers\BookController;

Route::get('/books', [BookController::class, 'index']);
Route::get('/get/all/books', [BookController::class, 'get_all']);


//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});
//
//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
