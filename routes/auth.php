<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthenticatedUserController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1/auth')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'register'])
        ->middleware('guest')
        ->name('auth.register');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('guest')
        ->name('auth.login');

    Route::get('/me', [AuthController::class, 'me'])
        ->middleware('auth:api')
        ->name('auth.me');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:api')
        ->name('auth.logout');

    Route::post('/refresh', [AuthController::class, 'refresh'])
        ->middleware('auth:api')
        ->name('auth.refresh');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('auth.password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('auth.password.store');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('auth.verification.send');
});

Route::prefix('auth/v1')->group(function () {
    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['auth', 'signed', 'throttle:6,1'])
        ->name('auth.verification.verify');
});
