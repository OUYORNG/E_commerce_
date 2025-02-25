<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;

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