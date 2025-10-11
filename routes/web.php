<?php

use App\Events\ChirpSent;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\ChirpController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

// LOGIN routes
Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', Register::class);
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', Login::class);
});

Route::middleware('auth')->group(function () {
    // Route::middleware('verified')->group(function () {
    Route::get('/', [ChirpController::class, 'index']);
    Route::post('/chirps', [ChirpController::class, 'store']);
    Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit']);
    Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']);
    Route::post('/logout', Logout::class)->name('logout');
    // });

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/home');
    })->middleware('signed')->name('verification.verify');

});

Route::get('/send-chirp', function () {
    // Sending a simple object instead of a model
    $chirp = [
        'message' => 'Hello from Laravel Reverb!',
        'user_id' => 1,
    ];

    // Fire the event
    broadcast(new ChirpSent($chirp));

    return response()->json(['status' => 'Message broadcasted!']);
});

Route::get('/receive-data', function () {
    return view('receive');
});
