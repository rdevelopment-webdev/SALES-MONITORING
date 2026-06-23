<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class RoleController extends Controller
{
    public function index()
    {
        return response()->json(Role::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_name' => 'required|string|max:255|unique:roles'
        ]);

        $role = Role::create($validated);

        return response()->json([
            'message' => 'Role created successfully',
            'role' => $role
        ], 201);
    }


    public function show(Role $role)
    {
        return response()->json($role->load('users', 'rolePagePermissions'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'role_name' => 'required|string|unique:roles,role_name,' . $id,
    ]);

    $role = Role::findOrFail($id);
    $role->update($request->only('role_name'));

    return response()->json(['message' => 'Role updated']);
}

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json([
            'message' => 'Role deleted successfully'
        ]);
    }
}
