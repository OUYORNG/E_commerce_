<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\Mailer\Event\MessageEvent;

class ProductController extends Controller
{
    public function getProductByCategoryID($categoryId){
        $products = Product::where("category_id", $categoryId)->get();

        if(!$products){
            return response()->json(['message' => 'Not Found'], Response::HTTP_BAD_REQUEST);
        }

    
        return response()->json($products,Response::HTTP_OK);
    }
    public function getAllProducts()
    {
        $products = Product::all();
        return response()->json($products, Response::HTTP_OK); 
    }

    public function createProduct(Request $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'pricing' => $request->pricing,
            'description' => $request->description,
            'images' => $request->images
        ]);

        return response()->json($product, Response::HTTP_CREATED); 
    }

    public function getProductById($productId)
    {
        $product = Product::find($productId);

        return response()->json($product, Response::HTTP_OK);
    }

    public function updateProductById(Request $request, $productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $product->update([
            'name' => $request->name,
        ]);

        return response()->json($product, Response::HTTP_OK);
    }

    public function deleteProductById($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND); 
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], Response::HTTP_OK); 
    }
}
