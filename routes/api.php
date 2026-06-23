<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductController,
    CategoryController,
    UploaderController,
    GuestSessionController
};

// -----------------------------
// Public / Guest Routes
// -----------------------------
Route::prefix('public')->group(function () {

    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);

    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);

    // Uploader Public Profile
    Route::get('/Uploaders/{Uploader}', [UploaderController::class, 'show']);

    // Guest Session Tracking (Hybrid model)
    Route::apiResource('guest-sessions', GuestSessionController::class)->only(['store', 'update']);
});
