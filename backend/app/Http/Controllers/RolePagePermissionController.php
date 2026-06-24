<?php

namespace App\Http\Controllers;

use App\Models\RolePagePermission;
use Illuminate\Http\Request;

class RolePagePermissionController extends Controller
{
    /**
     * List all permissions with role and page relationships.
     */
    public function index()
    {
        $permissions = RolePagePermission::with(['role', 'page'])->get();

        return response()->json([
            'message' => 'Permissions retrieved successfully',
            'data' => $permissions
        ]);
    }

    /**
     * Store a new permission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_id'         => 'required|integer|exists:roles,id',
            'page_id'         => 'required|integer|exists:pages,id',
            'permission_name' => 'required|string|max:255',
            'can_view'        => 'required|boolean',
            'can_create'      => 'required|boolean',
            'can_edit'        => 'required|boolean',
            'can_update'      => 'required|boolean',
        ]);

        // Prevent duplicate role + page combination
        $exists = RolePagePermission::where('role_id', $request->role_id)
            ->where('page_id', $request->page_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Permission for this role and page already exists.'
            ], 422);
        }

        $permission = RolePagePermission::create($request->all());

        return response()->json([
            'message' => 'Permission created successfully',
            'data' => $permission->load(['role', 'page'])
        ], 201);
    }

  
    public function show(RolePagePermission $rolePagePermission)
    {
        return response()->json([
            'message' => 'Permission retrieved successfully',
            'data' => $rolePagePermission->load(['role', 'page'])
        ]);
    }

    /**
     * Update a permission.
     */
    public function update(Request $request, RolePagePermission $rolePagePermission)
    {
        $request->validate([
            'role_id'         => 'sometimes|integer|exists:roles,id',
            'page_id'         => 'sometimes|integer|exists:pages,id',
            'permission_name' => 'sometimes|string|max:255',
            'can_view'        => 'sometimes|boolean',
            'can_create'      => 'sometimes|boolean',
            'can_edit'        => 'sometimes|boolean',
            'can_update'      => 'sometimes|boolean',
        ]);

        // Check for duplicates if role_id or page_id is changing
        if ($request->has('role_id') || $request->has('page_id')) {
            $roleId = $request->input('role_id', $rolePagePermission->role_id);
            $pageId = $request->input('page_id', $rolePagePermission->page_id);

            $exists = RolePagePermission::where('role_id', $roleId)
                ->where('page_id', $pageId)
                ->where('id', '<>', $rolePagePermission->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'Permission for this role and page already exists.'
                ], 422);
            }
        }

        $rolePagePermission->update($request->all());

        return response()->json([
            'message' => 'Permission updated successfully',
            'data' => $rolePagePermission->load(['role', 'page'])
        ]);
    }

    /**
     * Delete a permission.
     */
    public function destroy(RolePagePermission $rolePagePermission)
    {
        $rolePagePermission->delete();

        return response()->json([
            'message' => 'Permission deleted successfully'
        ]);
    }
}
