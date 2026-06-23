<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Archive;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class LeadController extends Controller
{

    public function index()
    {
        $leads = Lead::with('user')->get();
        return response()->json($leads);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'service_name' => 'required|string|max:255',
            'status_name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'job_position' => 'nullable|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255'
        ]);

        $lead = Lead::create($validated);

        // Log the creation
        AuditLog::create([
            'user_id' => auth()->id(),
            'time_log' => now(),
            'action' => 'Created lead: ' . $lead->business_name
        ]);

        return response()->json([
            'message' => 'Lead created successfully',
            'lead' => $lead
        ], 201);
    }

    public function show(Lead $lead)
    {
        return response()->json($lead->load('user', 'performancePlans', 'salesTasks'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,user_id',
            'service_name' => 'sometimes|string|max:255',
            'status_name' => 'sometimes|string|max:255',
            'business_name' => 'sometimes|string|max:255',
            'contact_person' => 'sometimes|string|max:255',
            'job_position' => 'nullable|string|max:255',
            'contact_number' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|max:255'
        ]);

        $lead->update($validated);

        // Log the update
        AuditLog::create([
            'user_id' => auth()->id(),
            'time_log' => now(),
            'action' => 'Updated lead: ' . $lead->business_name
        ]);

        return response()->json([
            'message' => 'Lead updated successfully',
            'lead' => $lead
        ]);
    }

    // ARCHIVE — Move to Archive table + create AuditLog
    public function destroy(Lead $lead)
    {
        // Create audit log first
        $auditLog = AuditLog::create([
            'user_id' => auth()->id(),
            'time_log' => now(),
            'action' => 'Archived lead: ' . $lead->business_name
        ]);

        // Create archive record with log_id
        Archive::create([
            'lead_id' => $lead->lead_id,
            'log_id' => $auditLog->log_id,
            'service_name' => $lead->service_name,
            'status_name' => $lead->status_name
        ]);

        $lead->delete();

        return response()->json([
            'message' => 'Lead archived successfully'
        ]);
    }
}
