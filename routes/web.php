<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Auth::routes(['verify' => true]);

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy']);
Route::prefix('attendance')->group(function () {
    Route::get('', [AttendanceController::class, 'index'])->name('index');
    Route::get('start', [AttendanceController::class, 'start'])->name('start');
    Route::get('end', [AttendanceController::class, 'end'])->name('end');
    Route::get('list/{num}', [AttendanceController::class, 'list'])->name('list');
});
Route::prefix('rest')->group(function () {
    Route::get('breakin', [RestController::class, 'breakin'])->name('breakin');
    Route::get('breakout', [RestController::class, 'breakout'])->name('breakout');
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['verified'])->name('dashboard');

require __DIR__.'/auth.php';

//メール認証
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/attendance');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/profile', function () {
    // 確認済みのユーザーのみがこのルートにアクセス可能
})->middleware('verified');


