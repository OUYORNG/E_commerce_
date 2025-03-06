<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('categories')->group(function () {
    Route::get('/', [CategoriesController::class, 'getAllCategories']);
    Route::post('/', [CategoriesController::class, 'createCategory']);
    Route::get('/{categoryId}', [CategoriesController::class, 'getCategoryById']);
    Route::patch('/{categoryId}', [CategoriesController::class, 'updateCategoryById']);
    Route::delete('/{categoryId}', [CategoriesController::class, 'deleteCategoryById']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'getAllProducts']);
    Route::post('/', [ProductController::class, 'createProduct']);
    Route::get('/{productId}', [ProductController::class, 'getProductById']);
    Route::patch('/{productId}', [ProductController::class, 'updateProductById']);
    Route::delete('/{productId}', [ProductController::class, 'deleteProductById']);
});
Route::get('/categories/{categoryId}/products', [ProductController::class, 'getProductByCategoryID']);