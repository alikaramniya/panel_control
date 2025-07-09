<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->middleware('auth')->name('home');

Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user', [UserController::class, 'user'])->name('profile.user');
    Route::post('/document/send', [DocumentController::class, 'store'])->name('user.document.send');
    Route::get('/document/list', [DocumentController::class, 'listDocument'])->name('document.list');
    /* Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); */
    /* Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); */
    /* Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); */
});

require __DIR__.'/auth.php';
