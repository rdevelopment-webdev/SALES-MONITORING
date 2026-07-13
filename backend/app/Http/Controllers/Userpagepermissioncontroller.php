<?php

namespace App\Http\Controllers;

use App\Models\UserPagePermission;
use Illuminate\Http\Request;

class UserPagePermissionController extends Controller
{
    /**
     * List overrides. Supports ?user_id= to filter for a single user
     * (mirrors how the frontend already fetches role_page_permissions).
     */
    public function index(Request $request)
    {
        $query = UserPagePermission::query();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        return response()->json($query->get());
    }

    /**
     * Create or update a single user's override for one page.
     * Upserts on (user_id, page_id) so the frontend doesn't need to
     * know the row id ahead of time.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'page_id'         => 'required|exists:pages,id',
            'permission_name' => 'nullable|string',
            'can_view'        => 'nullable|boolean',
            'can_create'      => 'nullable|boolean',
            'can_edit'        => 'nullable|boolean',
            'can_archive'     => 'nullable|boolean',
        ]);

        $permission = UserPagePermission::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'page_id' => $validated['page_id'],
            ],
            $validated
        );

        return response()->json($permission, 201);
    }

    public function show(UserPagePermission $userPagePermission)
    {
        return response()->json($userPagePermission);
    }

    public function update(Request $request, UserPagePermission $userPagePermission)
    {
        $validated = $request->validate([
            'permission_name' => 'nullable|string',
            'can_view'        => 'nullable|boolean',
            'can_create'      => 'nullable|boolean',
            'can_edit'        => 'nullable|boolean',
            'can_archive'     => 'nullable|boolean',
        ]);

        $userPagePermission->update($validated);

        return response()->json($userPagePermission);
    }

    /**
     * Remove an override entirely, reverting the user back to their role's default.
     */
    public function destroy(UserPagePermission $userPagePermission)
    {
        $userPagePermission->delete();

        return response()->json(['message' => 'Override removed.']);
    }
}
