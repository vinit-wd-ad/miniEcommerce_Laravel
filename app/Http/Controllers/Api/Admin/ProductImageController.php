<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = ProductImage::with('products')->get();
        
        if($images->isEmpty()){
            return response()->json([
                'status' => false,
                'message' => 'message not found',
                'data' => [],
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $images
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->all();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $image = ProductImage::create($data);

        return response()->json([
            'status' => true,
            'messgae' => 'image uploaded',
            'data' => $image,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $images = ProductImage::with('products')->findOrFail($id);
        
        if($images->isEmpty()){
            return response()->json([
                'status' => false,
                'message' => 'message not found',
                'data' => [],
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $images
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $image = ProductImage::find($id);

         $data = $request->all();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $image->create($data);

        return response()->json([
            'status' => true,
            'messgae' => 'image updated',
            'data' => $image,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = ProductImage::findOrFail($id);
        $image->delete();

        return response()->json([
            'message' => 'image deleted',
        ]);
    }
}
