<?php

use App\Events\ChirpSent;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\ChirpController;
use App\Models\Chirp;
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

    // $chirp->save();

    // Fire the event
    broadcast(new ChirpSent($chirp));

    return response()->json(['status' => 'Message broadcasted!']);
});

Route::get('/receive-data', function () {
    return view('receive');
});

// eyJpdiI6InJSQkZ3di9MMHZoaHZtSWM3SXJuUXc9PSIsInZhbHVlIjoiVzJ1Mm9iYVFmSXNzWXdRTVFMOG8wcHkrRFBhaFcxMVJBRU82bkJHU1dPSS9ESW9mQVU0N0QyVXRkKzB2dWdPeU5oVStPR2FHb2hBSVNUWnRQMy9lZHJ1dGRFc3BsdHovSTJGN0RQTC9XMnN6ckFzR2ZuKzNpbmlUTXlVQ0l6VE8iLCJtYWMiOiIyMmEwOWEwZGJiZWRkYmI5ZGQ4ZWEzY2NmOWExN2U2Yjc0NDJmYmY0MzdmZjYzZmM2NDc3ZDVjZWZhNTFjMWY1IiwidGFnIjoiIn0%3D
// eyJpdiI6InR4dU5UbkxsdTZlblpTc1hZY2s0Y3c9PSIsInZhbHVlIjoiK0lOZVBlOHVyYjNGbXNMcjU3OHo4RzVpM2FGVTlUZk8reXMxNnkxV1FYT2pnWDBGRGlLQ2xtUTM0bUI0OFB2TU9OcGJheE1zQStadmhaYVFTd0FLaG5FL0tyZGZ3aCtiQ0FGQVJXNmMzYVMvZkZWN3ZoUkNlMHhrdkdub0tJeDIiLCJtYWMiOiIwNjhlNDdjODNjMjM2NGNjYTdjNDIwMGY2N2U0NzIyZGQ2NGZmOWJlZTRiYzU1NTI3MTQ0MDYwYTU5ZmIwNTk0IiwidGFnIjoiIn0%3D
