<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get calculated cart details with full product information
     * 
     * @param Request $request Expects 'cart_items' array from session
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCartDetails(Request $request)
    {
        // 1. Validate payload
        $request->validate([
            'cart_items'              => 'present|array',
            'cart_items.*.product_id' => 'required|integer',
            'cart_items.*.quantity'   => 'required|integer|min:1',
        ]);

        $cartItems = $request->input('cart_items', []);

        // Return empty payload early if cart is empty
        if (empty($cartItems)) {
            return response()->json([
                'status'  => true,
                'message' => 'Cart is empty',
                'data'    => [
                    'items'       => [],
                    'subtotal'    => 0,
                    'total_items' => 0
                ]
            ], 200);
        }

        // 2. Extract unique product IDs from session payload
        $productIds = collect($cartItems)->pluck('product_id')->unique()->toArray();

        // 3. Fetch all products in a single SQL query
        $products = Product::whereIn('id', $productIds)
            ->where('is_active', 1) // Optional: active products only
            ->get()
            ->keyBy('id'); // Key by ID for fast $products[$id] lookup

        $formattedItems = [];
        $subtotal = 0;
        $totalQuantity = 0;

        // 4. Map and Calculate totals
        foreach ($cartItems as $item) {
            $productId = $item['product_id'];
            $quantity  = $item['quantity'];

            if (isset($products[$productId])) {
                $product = $products[$productId];

                // Use discount price if available, else regular price
                $unitPrice = $product->sale_price ?? $product->price;
                $itemTotal = $unitPrice * $quantity;

                $formattedItems[] = [
                    'item_id'    => $item['item_id'] ?? null,
                    'product_id' => $product->id,
                    'name'       => $product->name,
                    'slug'       => $product->slug ?? null,
                    'image'      => $product->image ? asset('storage/' . $product->image) : null,
                    'unit_price' => (float) $unitPrice,
                    'quantity'   => (int) $quantity,
                    'item_total' => (float) $itemTotal,
                ];

                $subtotal      += $itemTotal;
                $totalQuantity += $quantity;
            }
        }

        // 5. Return complete single-payload calculation
        return response()->json([
            'status'  => true,
            'message' => 'Cart details fetched successfully',
            'data'    => [
                'items'       => $formattedItems,
                'subtotal'    => (float) $subtotal,
                'total_items' => (int) $totalQuantity,
            ]
        ], 200);
    }
}
