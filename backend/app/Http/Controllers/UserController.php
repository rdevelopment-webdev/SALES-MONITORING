<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
        ]);

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

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => 'sometimes|integer|exists:roles,id',
            'full_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = $request->password;
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user->load('role')
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        $user->archived_by = $request->user()?->id;
        $user->save();
        $user->delete();

        return response()->json([
            'message' => 'User archived successfully'
        ]);
    }

    public function archived()
    {
        $users = User::onlyTrashed()
            ->with(['role', 'archivedBy'])
            ->get()
            ->map(function (User $user) {
                return [
                    'id' => $user->id,
                    'role_id' => $user->role_id,
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    'deleted_at' => $user->deleted_at,
                    'archived_by' => $user->archived_by,
                    'archived_by_name' => $user->archivedBy?->full_name,
                    'archived_by_email' => $user->archivedBy?->email,
                ];
            });

        return response()->json($users);
    }

    public function archiveSelected(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:users,id',
        ]);

        User::whereIn('id', $validated['ids'])->update([
            'archived_by' => $request->user()?->id,
        ]);
        User::whereIn('id', $validated['ids'])->delete();

        return response()->json([
            'message' => 'Users archived successfully'
        ]);
    }

    public function restore(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->archived_by = null;
        $user->save();
        $user->restore();

        return response()->json([
            'message' => 'User restored successfully',
            'user' => $user->load('role'),
        ]);
    }

    public function forceDelete(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return response()->json([
            'message' => 'Archived user permanently deleted'
        ]);
    }

    }
