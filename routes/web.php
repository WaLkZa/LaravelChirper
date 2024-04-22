<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('feed', [ChirpController::class, 'feed'])->middleware(['auth', 'verified'])->name('feed');

Route::get('chirps', [ChirpController::class, 'index'])->middleware(['auth', 'verified'])->name('chirps.index');
Route::get('chirps/create', [ChirpController::class, 'create'])->middleware(['auth', 'verified'])->name('chirps.create');
Route::get('chirps/{chirp}/like', [ChirpController::class, 'like'])->middleware(['auth', 'verified'])->name('chirps.like');
Route::post('chirps', [ChirpController::class, 'store'])->middleware(['auth', 'verified'])->name('chirps.store');
Route::get('chirps/{chirp}', [ChirpController::class, 'show'])->middleware(['auth', 'verified'])->name('chirps.show');
Route::get('chirps/{chirp}/edit', [ChirpController::class, 'edit'])->middleware(['auth', 'verified'])->name('chirps.edit');
Route::post('chirps/{chirp}', [ChirpController::class, 'update'])->middleware(['auth', 'verified'])->name('chirps.update');
Route::get('chirps/{chirp}/delete', [ChirpController::class, 'destroy'])->middleware(['auth', 'verified'])->name('chirps.destroy');

Route::get('discover', [UsersController::class, 'index'])->name('discover');
Route::get('discover/{user}', [UsersController::class, 'foreign'])->name('foreign_user');
Route::get('follow/{user}', [UsersController::class, 'follow'])->name('user_follow');
