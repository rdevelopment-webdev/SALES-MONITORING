<?php

namespace App\Http\Controllers;

use App\Models\Sales_Task;
use Illuminate\Http\Request;

class SalesTaskController extends Controller
{
    public function index()
    {
        $tasks = Sales_Task::with('user')->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'task_date' => 'required|date',
            'task_notes' => 'nullable|string',
            'exported_file_path' => 'nullable|string|max:255'
        ]);

        $task = Sales_Task::create($validated);

        return response()->json([
            'message' => 'Sales task created successfully',
            'task' => $task
        ], 201);
    }

    public function show(Sales_Task $salesTask)
    {
        return response()->json($salesTask->load('user'));
    }

    public function update(Request $request, Sales_Task $salesTask)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,user_id',
            'task_date' => 'sometimes|date',
            'task_notes' => 'nullable|string',
            'exported_file_path' => 'nullable|string|max:255'
        ]);

        $salesTask->update($validated);

        return response()->json([
            'message' => 'Sales task updated successfully',
            'task' => $salesTask
        ]);
    }

    public function destroy(Sales_Task $salesTask)
    {
        $salesTask->delete();

        return response()->json([
            'message' => 'Sales task deleted successfully'
        ]);
    }
}
