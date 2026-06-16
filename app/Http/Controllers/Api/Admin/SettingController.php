<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Get the current website settings.
     */
    public function index()
    {
        $settings = Setting::first();

        if (!$settings) {
            return response()->json([
                'status' => true,
                'message' => 'No settings found, please update to create one.',
                'data' => null
            ]);
        }

        if ($settings->site_logo) {
            $settings->site_logo_url = asset('storage/' . $settings->site_logo);
        }
        if ($settings->site_favicon) {
            $settings->site_favicon_url = asset('storage/' . $settings->site_favicon);
        }

        return response()->json([
            'status' => true,
            'data' => $settings
        ]);
    }

    /**
     * Update or Create website settings.
     */
    public function update(Request $request, string $id = null)
    {
        $settings = Setting::first();

        // Validation rules
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpg,png,jpeg,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:jpg,png,jpeg,ico,png|max:1024',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except(['site_logo', 'site_favicon']);

        // Handle site_logo Upload
        if ($request->hasFile('site_logo')) {
            if ($settings && $settings->site_logo) {
                Storage::disk('public')->delete($settings->site_logo);
            }
            $data['site_logo'] = $request->file('site_logo')->store('settings', 'public');
        }

        // Handle site_favicon Upload
        if ($request->hasFile('site_favicon')) {
            if ($settings && $settings->site_favicon) {
                Storage::disk('public')->delete($settings->site_favicon);
            }
            $data['site_favicon'] = $request->file('site_favicon')->store('settings', 'public');
        }

        if ($request->has('is_active')) {
            $data['is_active'] = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);
        }

        $updatedSettings = Setting::updateOrCreate(
            ['id' => 1],
            $data
        );

        return response()->json([
            'status' => true,
            'message' => 'Settings updated successfully',
            'data' => $updatedSettings
        ]);
    }

    public function store(Request $request){
        return $this->update($request);
    }
}