<?php

namespace App\Http\Controllers;

use App\Models\SalesTask;
use Illuminate\Http\Request;

class SalesTaskController extends Controller
{
    public function index()
    {
        $tasks = SalesTask::active()->with('user')->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'task_date' => 'required|date',
            'checklist' => 'nullable|array',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        // The sales_task table stores checklist + progress together as a
        // JSON string in task_notes (see mapApiRecord() on the frontend,
        // which parses task_notes back into { checklist, progress }).
        // checklist/progress aren't real columns, so they're packed here
        // and removed before create().
        $validated['task_notes'] = json_encode([
            'checklist' => $validated['checklist'] ?? [],
            'progress' => $validated['progress'] ?? 0,
        ]);
        unset($validated['checklist'], $validated['progress']);

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
            'checklist' => 'nullable|array',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        if (array_key_exists('checklist', $validated) || array_key_exists('progress', $validated)) {
            $existing = json_decode($salestask->task_notes ?? '{}', true) ?: [];

            $validated['task_notes'] = json_encode([
                'checklist' => $validated['checklist'] ?? ($existing['checklist'] ?? []),
                'progress' => $validated['progress'] ?? ($existing['progress'] ?? 0),
            ]);
        }
        unset($validated['checklist'], $validated['progress']);

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
