<?php

use app\Http\Controllers\API\V1\AuthController;
use app\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(static function (): void {
    Route::prefix('/auth')->group(static function (): void {
        Route::post('/login', [AuthController::class, 'login'])->name('api.v1.auth.login');
        Route::post('/registration', [AuthController::class, 'register'])->name('api.v1.auth.register');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('api.v1.auth.refresh');
    });

    Route::middleware(['auth:api'])->group(static function (): void {
        Route::get('/profile', [UserController::class, 'profile'])->name('api.v1.users.profile');
    });
});

