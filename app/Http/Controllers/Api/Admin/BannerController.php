<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /* Display all banners */
    public function index()
    {
        $banners = Banner::orderBy('short_order', 'asc')->get();

        return response()->json([
            'status' => true,
            'data' => $banners
        ]);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'info'        => 'nullable|string|max:500',
            'target_url'  => 'nullable|url|max:255',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_order' => 'nullable|integer',
            'type'        => 'nullable||in:hero_banner,offer_banner,sidebar_banner',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = $request->only([
            'title',
            'info',
            'target_url',
            'short_order',
            'type',
            'is_active'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('banners', 'public');
        }

        $banner = Banner::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Banner created successfully',
            'data'    => $banner
        ], 201);
    }
    public function show(string $id)
    {
        $banner = Banner::findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => $banner
        ]);
    }

    public function update(Request $request, string $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'info'        => 'nullable|string|max:500',
            'target_url'  => 'nullable|url|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // update me optional hai
            'short_order' => 'nullable|integer',
            'type'        => 'nullable|string|max:100',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = $request->only([
            'title',
            'info',
            'target_url',
            'short_order',
            'type',
            'is_active'
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $data['image'] = $request
                ->file('image')
                ->store('banners', 'public');
        }

        $banner->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Banner updated successfully',
            'data'    => $banner
        ]);
    }

    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Banner deleted successfully'
        ]);
    }
    
}
