<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialLink;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socialLinks = SocialLink::orderBy('sort_order', 'asc')->get();

        if ($socialLinks->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No social links found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $socialLinks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer'
        ]);

        $data = $request->all();

        if ($request->has('is_active')) {
            $data['is_active'] = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);
        }

        $socialLink = SocialLink::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Social link created successfully',
            'data' => $socialLink
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $socialLink = SocialLink::find($id);

        if (!$socialLink) {
            return response()->json([
                'status' => false,
                'message' => 'Social link not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $socialLink
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $socialLink = SocialLink::find($id);

        if (!$socialLink) {
            return response()->json([
                'status' => false,
                'message' => 'Social link not found'
            ], 404);
        }

        $request->validate([
            'platform' => 'sometimes|required|string|max:255',
            'url' => 'sometimes|required|url|max:255',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer'
        ]);

        $data = $request->all();

        // Sometime frontend sends string 'true'/'false'
        if ($request->has('is_active')) {
            $data['is_active'] = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);
        }

        $socialLink->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Social link updated successfully',
            'data' => $socialLink
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $socialLink = SocialLink::find($id);

        if (!$socialLink) {
            return response()->json([
                'status' => false,
                'message' => 'Social link not found'
            ], 404);
        }

        $socialLink->delete();

        return response()->json([
            'status' => true,
            'message' => 'Social link deleted successfully'
        ]);
    }
}