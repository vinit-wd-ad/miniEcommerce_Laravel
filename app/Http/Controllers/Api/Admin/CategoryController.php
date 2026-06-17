<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // List all categories
    public function index()
    {
        $categories = ProductCategory::get();

        if ($categories->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No categories found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $categories
        ]);
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        $data = $request->all();

        // slug auto generate
        $data['slug'] = Str::slug($request->name);

        // image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category = ProductCategory::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Category created',
            'data' => $category
        ], 201);
    }

    // Show single category
    public function show($id)
    {
        $category = ProductCategory::with('children')->findOrFail($id);

        return response()->json($category);
    }

    // Update category
    public function update(Request $request, $id)
    {
        $category = ProductCategory::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Category updated',
            'data' => $category
        ]);
    }

    // Delete category
    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'Category deleted'
        ]);
    }
}
