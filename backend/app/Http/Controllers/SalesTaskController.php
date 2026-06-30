<?php

namespace App\Http\Controllers;

use App\Models\SalesTask;
use Illuminate\Http\Request;

class SalesTaskController extends Controller
{
    public function index()
    {
        $tasks = SalesTask::with('user')->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'task_date' => 'required|date',
            'task_notes' => 'nullable|string', 
        ]);

        $task = SalesTask::create($validated);

        return response()->json([
            'message' => 'Sales task created successfully',
            'task' => $task
        ], 201);
    }

    public function show(SalesTask $salestask)
    {
        return response()->json($salestask->load('user'));
    }

    public function update(Request $request, SalesTask $salestask)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'task_date' => 'sometimes|date',
            'task_notes' => 'nullable|string',
        ]);

        $salestask->update($validated);

        return response()->json([
            'message' => 'Sales task updated successfully',
            'task' => $salestask
        ]);
    }

    public function destroy(SalesTask $salestask)
    {
        $salestask->delete();

        return response()->json([
            'message' => 'Sales task deleted successfully'
        ]);
    }
}
