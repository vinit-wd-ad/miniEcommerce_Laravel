<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::get();

        return response()->json([
            'status' => true,
            'data' => $categories
        ]);
    }

    public function show($id)
    {
        $category = ProductCategory::with('children')->find($id);

        if (!$category) {
            return response()->json(['status' => false, 'message' => 'Category not found'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }

    public function categoryProduct()
    {
        $categories = ProductCategory::with('products')->get();

        return response()->json([
            'status' => true,
            'data' => $categories
        ]);
    }
}