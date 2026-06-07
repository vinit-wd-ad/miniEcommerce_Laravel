<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'products not found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        return response()->json([
            'status' => true,
            'message' => 'product created',
            'data' => $data,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('images')->findOrFail($id);

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'product not found'
            ], 404);
        }

        $data = $request->all();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return response()->json([
            'status' => true,
            'message' => 'product updated',
            'data' => $data,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'product deleted',
        ]);
    }
}
