<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
}
