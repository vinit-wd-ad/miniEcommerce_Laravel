<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Display all images
     */
    public function index()
    {
        $images = ProductImage::with('product')->get();

        return response()->json([
            'status' => true,
            'data' => $images
        ]);
    }

    /**
     * Store image
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_primary' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'product_id',
            'is_primary',
            'is_active'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        // Only one primary image per product
        if (!empty($request->is_primary)) {
            ProductImage::where(
                'product_id',
                $request->product_id
            )->update([
                'is_primary' => 0
            ]);
        }

        $image = ProductImage::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Image uploaded successfully',
            'data' => $image
        ], 201);
    }

    /**
     * Show single image
     */
    public function show(string $id)
    {
        $image = ProductImage::with('product')
            ->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $image
        ]);
    }

    /**
     * Update image
     */
    public function update(Request $request, string $id)
    {
        $image = ProductImage::findOrFail($id);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_primary' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'product_id',
            'is_primary'
        ]);

        if ($request->hasFile('image')) {

            if (
                $image->image &&
                Storage::disk('public')->exists($image->image)
            ) {
                Storage::disk('public')->delete($image->image);
            }

            $data['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        // Only one primary image per product
        if (!empty($request->is_primary)) {
            ProductImage::where(
                'product_id',
                $request->product_id
            )
                ->where('id', '!=', $id)
                ->update([
                    'is_primary' => 0
                ]);
        }

        $image->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Image updated successfully',
            'data' => $image
        ]);
    }

    /**
     * Delete image
     */
    public function destroy(string $id)
    {
        $image = ProductImage::findOrFail($id);

        if (
            $image->image &&
            Storage::disk('public')->exists($image->image)
        ) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return response()->json([
            'status' => true,
            'message' => 'Image deleted successfully'
        ]);
    }

    /**
     * Product wise images
     */
    public function getProductImages($productId)
    {
        $images = ProductImage::where(
            'product_id',
            $productId
        )
            ->orderByDesc('is_primary')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $images
        ]);
    }

    /**
     * Toggle active status of a product image
     */
    public function toggleStatus(string $id)
    {
        $image = ProductImage::findOrFail($id);
        $image->is_active = !$image->is_active;
        $image->save();

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully',
            'is_active' => $image->is_active
        ]);
    }
}
