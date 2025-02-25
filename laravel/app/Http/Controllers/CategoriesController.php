<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
    public function getAllCategories()
    {
        $categories = Category::all();
        return response()->json($categories, Response::HTTP_OK); // 200
    }

    public function createCategory(Request $request)
    {
        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json($category, Response::HTTP_CREATED); // 201
    }

    public function getCategoryById($categoryId)
    {
        $category = Category::find($categoryId);

        return response()->json($category, Response::HTTP_OK); // 200
    }

    public function updateCategoryById(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND); // 404
        }

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json($category, Response::HTTP_OK); // 200
    }

    public function deleteCategoryById($categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND); // 404
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], Response::HTTP_OK); // 200
    }
}
