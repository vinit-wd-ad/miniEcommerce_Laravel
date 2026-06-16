<?php

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\ProductImageController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\Admin\SocialLinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/admin/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::apiResource('/category', CategoryController::class);
    Route::apiResource('/product', ProductController::class);
    Route::apiResource('/product-images', ProductImageController::class);
    Route::get('/products/{product}/images',[ProductImageController::class, 'getProductImages']);

    Route::apiResource('admin', AdminController::class);
    Route::apiResource('setting', SettingController::class);
    Route::apiResource('social-links', SocialLinkController::class);
    Route::get('/dashboard', function () {
        return response()->json(['message' => 'Welcome Admin']);
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
