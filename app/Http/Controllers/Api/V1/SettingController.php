<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::firstOrFail();

        if (!$settings) {
            return response()->json([
                'status' => false,
                'message' => 'data not found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => $settings
        ]);
    }

    public function socialLinks()
    {
        $links = SocialLink::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        if($links->isEmpty){
            return response()->json([
                'status' => false,
                'message' => 'No record found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => $links
        ]);
    }
}
