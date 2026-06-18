<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('short_order', 'asc')->get();

        return response()->json([
            'status' => true,
            'data' => $banners
        ]);
    }

    public function show(string $id)
    {
        $banner = Banner::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $banner
        ]);
    }

    public function bannerType(string $type)
    {
        $banner = Banner::where('type', $type)
                            ->orderBy('short_order', 'asc')
                            ->where('is_active', true)
                            ->get();

        return response()->json([
            'status' => true,
            'data' => $banner
        ]);
    }
}
