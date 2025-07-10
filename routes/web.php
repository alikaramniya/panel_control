<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->middleware('auth')->name('home');

Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware(['auth', 'verified'])->can('isAdmin')->name('dashboard');

Route::middleware(['can:isAdmin', 'auth'])->prefix('user')->controller(UserController::class)->group(function () {
    Route::get('/search', 'search')->name('user.search');
    Route::get('/toggle/{user}', 'toggle')->name('user.toggle.role');
    Route::get('/create', 'create')->name('user.create');
    Route::post('/store', 'store')->name('user.store');
    Route::get('/update', 'updatePassword')->name('user.update.password');
    Route::get('/user', 'user')->name('profile.user');
});
Route::middleware(['can:isAdmin', 'auth'])->prefix('document')->controller(DocumentController::class)->group(function () {
    Route::post('/send', 'store')->name('user.document.send');
    Route::get('/list', 'listDocument')->name('document.list');
    Route::get('/download/{document}', 'download')->name('document.download');
    Route::get('/show/{document}', 'show')->name('document.show');
});
Route::middleware('auth')->group(function () {
    /* Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); */
    /* Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); */
    /* Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); */
});

require __DIR__.'/auth.php';
