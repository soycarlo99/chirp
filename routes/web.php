<?php

use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;

// LOGIN routes
Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', Register::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [ChirpController::class, 'index']);
    Route::post('/chirps', [ChirpController::class, 'store']);
    Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit']);
    Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']);
});
