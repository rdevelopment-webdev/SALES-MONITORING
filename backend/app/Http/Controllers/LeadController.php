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
            'user_id' => 'required|exists:users,id',
            'business_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'job_position' => 'nullable|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'service_name' => 'required|string|max:255',
            'status_name' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'location' => 'required|string',
        ]);

        $lead = Lead::create($validated);

        // Fallback: use auth user, or the lead's user_id if not authenticated
        $actorId = auth()->id() ?? $validated['user_id'];

        AuditLog::create([
            'user_id' => $actorId,
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
        return response()->json($lead->load('user'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'business_name' => 'sometimes|string|max:255',
            'contact_person' => 'sometimes|string|max:255',
            'job_position' => 'nullable|string|max:255',
            'contact_number' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|max:255',
            'service_name' => 'sometimes|string|max:255',
            'status_name' => 'sometimes|string|max:255',
            'remarks' => 'nullable|string',
            'location' => 'sometimes|string',
        ]);

        $lead->update($validated);

        $actorId = auth()->id() ?? $lead->user_id;

        AuditLog::create([
            'user_id' => $actorId,
            'time_log' => now(),
            'action' => 'Updated lead: ' . $lead->business_name
        ]);

        return response()->json([
            'message' => 'Lead updated successfully',
            'lead' => $lead
        ]);
    }

    public function destroy(Lead $lead)
    {
        $actorId = auth()->id() ?? $lead->user_id;

        $auditLog = AuditLog::create([
            'user_id' => $actorId,
            'time_log' => now(),
            'action' => 'Archived lead: ' . $lead->business_name
        ]);

        Archive::create([
            'lead_id' => $lead->id,        // ✅ was $lead->lead_id
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