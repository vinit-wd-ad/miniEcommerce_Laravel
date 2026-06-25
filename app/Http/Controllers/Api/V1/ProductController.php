<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No products found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => $products
        ]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => $product,
        ]);
    }

    public function slug($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => $product,
        ]);
    }

    public function categoryProduct($slug)
    {
        $category = ProductCategory::where('slug', $slug)->firstOrFail();

        $products = $category->products;

        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }
}
