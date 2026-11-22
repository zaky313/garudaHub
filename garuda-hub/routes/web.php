<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('projects.index'));

// Autentikasi (throttle membatasi percobaan berulang)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::resource('projects', ProjectController::class);

Route::post('projects/{project}/bids', [BidController::class, 'store'])->name('bids.store');
Route::post('projects/{project}/bids/{bid}/pick', [BidController::class, 'pick'])->name('bids.pick');
Route::delete('bids/{bid}', [BidController::class, 'destroy'])->name('bids.destroy');