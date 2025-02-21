<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ProfileController;

Route::get('/', [FotoController::class, 'public']);

Route::get('/dashboard', [FotoController::class, 'public'])->middleware(['auth', 'verified'])->name('dashboard');;
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('fotos', FotoController::class);

    Route::post('/fotos/toggle-like', [FotoController::class, 'toggleLike'])->name('likes.toggle')->middleware('auth');

    Route::post('/fotos/{id}/update-album', [FotoController::class, 'updateAlbum'])->name('fotos.updateAlbum');

    Route::post('/fotos/{foto}/komentar', [FotoController::class, 'storeKomentar'])->name('fotos.komentar.store');
    Route::post('/albums/{album}/remove-photo/{foto}', [AlbumController::class, 'removePhoto'])->name('albums.removePhoto');
    Route::resource('albums', AlbumController::class);
});

require __DIR__ . '/auth.php';


Route::get('/public', [FotoController::class, 'public'])->name('public');
Route::get('/fotos/{foto}', [FotoController::class, 'show'])->name('fotos.show');   
