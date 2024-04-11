<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('tags', TagController::class);
    Route::apiResource('users', UserController::class)->middleware('admin');

    Route::get('/reviews/{product}', [ReviewController::class, 'index']);
    Route::post('/reviews/store/{product}', [ReviewController::class, 'store']);
    Route::put('/reviews/update/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/delete/{review}', [ReviewController::class, 'destroy']);

    Route::post('/ratings/create/{product}', [RatingController::class, 'store']);
    Route::post('/ratings/delete/{product}', [RatingController::class, 'destroy']);
    
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{product}', [CartController::class, 'store']);
    Route::post('/cart/remove/{product}', [CartController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
