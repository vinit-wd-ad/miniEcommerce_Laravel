<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     * Restricts regular users to only view their own record.
     */
    public function index(Request $request)
    {
        if (auth()->guard('admin-api')->check()) {
            $users = User::latest()->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No users found',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => true,
                'message' => 'All users fetched successfully',
                'data' => $users
            ], 200);
        }

        $currentUser = $request->user();

        if (!$currentUser) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated access'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'User record fetched successfully',
            'data' => [$currentUser]
        ], 200);
    }

    /**
     * Store a newly created user in storage (Registration / Creation).
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // Note: Password is automatically hashed via model casting ('password' => 'hashed')
        $user = User::create($validatedData);

        return response()->json([
            'status'  => true,
            'message' => 'User created successfully',
            'data'    => $user
        ], 201);
    }

    /**
     * Display the specified user.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $user
        ], 200);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found'
            ], 404);
        }

        $validatedData = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'email'    => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
        ]);

        // Remove password from update payload if it is null or empty
        if (empty($validatedData['password'])) {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json([
            'status'  => true,
            'message' => 'User updated successfully',
            'data'    => $user
        ], 200);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found'
            ], 404);
        }

        // Revoke active tokens and delete the user
        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'status'  => true,
            'message' => 'User deleted successfully'
        ], 200);
    }

    /**
     * Authenticate user and return token.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Generate Sanctum access token for user
        $token = $user->createToken('user-token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => $user
        ], 200);
    }
}
