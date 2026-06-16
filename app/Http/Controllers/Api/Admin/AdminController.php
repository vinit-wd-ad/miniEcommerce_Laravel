<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin; 
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentAdmin = $request->user();

        if ($currentAdmin->role === 'superAdmin') {
            // Fetch all users if role==superAdmin
            $admins = Admin::get();
        } elseif ($currentAdmin->role === 'admin') {
            // admin can see any type of user other than superAdmin
            $admins = Admin::where('role', '!=', 'superAdmin')->get();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        if ($admins->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No administrators found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $admins
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentAdmin = $request->user();

        // Only superAdmin & admin can create new users
        if (!in_array($currentAdmin->role, ['superAdmin', 'admin'])) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string'
        ]);

        // admin can create new user but can not assign superAdmin role to users
        if ($currentAdmin->role === 'admin' && $request->role === 'superAdmin') {
            return response()->json([
                'status' => false,
                'message' => 'You cannot create a user with superAdmin role.'
            ], 403);
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Admin created successfully',
            'data' => $admin
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $currentAdmin = $request->user();
        $targetAdmin = Admin::find($id);

        if (!$targetAdmin) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        if (
            $currentAdmin->role === 'superAdmin' ||
            $currentAdmin->id == $id ||
            ($currentAdmin->role === 'admin' && $targetAdmin->role !== 'superAdmin')
        ) {
            return response()->json([
                'status' => true,
                'data' => $targetAdmin
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Unauthorized to view this profile'
        ], 403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $currentAdmin = $request->user();
        $targetAdmin = Admin::find($id);

        if (!$targetAdmin) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        $canUpdate = false;

        // NEW PERMISSION LOGIC HERE
        if ($currentAdmin->role === 'superAdmin') {
            $canUpdate = true;
        } elseif ($currentAdmin->id == $id) {
            // Every type off role can update/edit himself profile
            $canUpdate = true;
        } elseif ($currentAdmin->role === 'admin' && !in_array($targetAdmin->role, ['superAdmin', 'admin'])) {
            // admin can edit lower admin role type of users
            $canUpdate = true;
        }

        if (!$canUpdate) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized to update this record'
            ], 403);
        }

        // Validation
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'sometimes|required|string'
        ]);

        $data = $request->only(['name', 'email']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Role update restrictions
        if ($request->has('role')) {
            if ($currentAdmin->role === 'superAdmin') {
                $data['role'] = $request->role;
            } elseif ($currentAdmin->role === 'admin' && !in_array($request->role, ['superAdmin', 'admin'])) {
                // Admin can assign only lower roles
                $data['role'] = $request->role;
            } else {
                if ($currentAdmin->id == $id && $currentAdmin->role !== $request->role) {
                    return response()->json(['status' => false, 'message' => 'You cannot change your own role.'], 403);
                }
            }
        }

        $targetAdmin->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $targetAdmin
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $currentAdmin = $request->user();
        $targetAdmin = Admin::find($id);

        if (!$targetAdmin) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        if ($currentAdmin->id == $id) {
            return response()->json(['status' => false, 'message' => 'You cannot delete yourself'], 400);
        }

        if (
            $currentAdmin->role === 'superAdmin' ||
            ($currentAdmin->role === 'admin' && !in_array($targetAdmin->role, ['superAdmin', 'admin']))
        ) {
            $targetAdmin->delete();
            return response()->json([
                'status' => true,
                'message' => 'Record deleted successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Unauthorized to delete this record'
        ], 403);
    }
}