<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  Route::resource('posts', PostController::class)->except(['show', 'edit'])->missing(function () {
    return Inertia::render('404');
  });
  Route::get('/posts/{author}/{slug}/edit', [PostController::class, 'edit'])->name('posts.edit');
});

Route::get('/posts/{author}/{slug}', [PostController::class, 'show'])->name('posts.show');
require __DIR__.'/auth.php';
