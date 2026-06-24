<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        
       

        $validated = $request->validate([
            'role_id' => 'required|integer|exists:roles,id',
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'email' => 'required|email|unique:users,email',
            // 'contact_number' => 'nullable|string|max:20'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function show(User $user)
    {
        // return response()->json($user->load('role', 'leads', 'salesTasks', 'performancePlans', 'auditLogs'));
        return response()->json($user->load('role'));
    }
    
    public function leads()
{
    return $this->hasMany(Lead::class, 'user_id');
}

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => 'sometimes|exists:roles,role_id',
            'full_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->user_id . ',id',
            'contact_number' => 'nullable|string|max:20'
        ]);

        if ($request->has('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function archived()
    {
        $users = User::onlyTrashed()->with('role')->get();
        return response()->json($users);
        return response()->json([
            'message' => 'User archived successfully'
        ]);
    }


   public function restore(Request $request, int $id)
{
    $columnUserId = 'user_id';
    $columnIsArchived = 'is_archived';

    $user = User::where($columnUserId, $id)
                ->where($columnIsArchived, true)
                ->first();
}

    }

