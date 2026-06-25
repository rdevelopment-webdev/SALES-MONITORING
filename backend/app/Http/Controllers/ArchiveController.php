<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        // Use RELATIONSHIP names, not column names
        $archives = Archive::with(['lead', 'auditLog', 'performancePlan', 'salesTask'])->get();
        return response()->json($archives);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'log_id' => 'required|exists:audit_logs,id',
            'performance_id' => 'required|exists:performance_plans,id',
            'task_id' => 'required|exists:sales_tasks,id',  // <-- migration says 'tasks', not 'sales_tasks'
            'service_name' => 'required|string',
            'status_name' => 'required|string',
        ]);

        $archive = Archive::create($validated);
        return response()->json($archive, 201);
    }

    public function update(Request $request, Archive $archive)
{
    $validated = $request->validate([
        'lead_id' => 'sometimes|exists:leads,id',
        'log_id' => 'sometimes|exists:audit_logs,id',
        'performance_id' => 'sometimes|exists:performance_plans,id',
        'task_id' => 'sometimes|exists:sales_tasks,id',
        'service_name' => 'sometimes|string',
        'status_name' => 'sometimes|string',
    ]);

    $archive->update($validated);

    return response()->json($archive);
}

    public function show(Archive $archive)
    {
        return response()->json($archive->load('lead', 'auditLog', 'performancePlan', 'salesTask'));
    }

    public function destroy(Archive $archive)
    {
        $archive->delete();
        return response()->json([
            'message' => 'Archive permanently deleted'
        ]);
    }
}