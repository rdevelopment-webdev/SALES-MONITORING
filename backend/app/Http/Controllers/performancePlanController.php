<?php

namespace App\Http\Controllers;

use App\Models\PerformancePlan;
use Illuminate\Http\Request;

class PerformancePlanController extends Controller
{
    public function index()
    {
        $plans = PerformancePlan::whereNull('archived_at')
            ->with('user', 'technique', 'service', 'salesRepresentative', 'waysOfCommunication')
            ->get();
    return response()->json($plans);
    }

    /**
     * List archived plans only. Backs the frontend's
     * GET /api/pip-records/archived call.
     */
    public function archived()
    {
        $plans = PerformancePlan::whereNotNull('archived_at')
            ->with('user', 'technique', 'service', 'salesRepresentative', 'waysOfCommunication')
            ->orderByDesc('archived_at')
            ->get();
        return response()->json($plans);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date_recorded' => 'required|date',
            'client_name' => 'required|string|max:255',
            'technique_id' => 'required|exists:prospect_techniques,id',
            'email' => 'required|email|max:255',
            'service_id' => 'required|exists:services,id',
            'status' => 'required|string|max:255',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'area_input' => 'nullable|string|max:255',
            'representative__id' => 'required|exists:sales__representatives,id',  // double underscore
            'onboarding_date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'contact_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'communication_id' => 'required|exists:ways_of_communication,id'
        ]);

        $plan = PerformancePlan::create($validated);

        return response()->json([
            'message' => 'Performance plan created successfully',
            'plan' => $plan->load('user', 'technique', 'service', 'salesRepresentative', 'waysOfCommunication')
        ], 201);
    }

    public function show(PerformancePlan $performance_plan)
    {
        return response()->json($performance_plan->load('user', 'technique', 'service', 'salesRepresentative', 'waysOfCommunication'));
    }

    public function update(Request $request, PerformancePlan $performance_plan)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'date_recorded' => 'sometimes|date',
            'client_name' => 'sometimes|string|max:255',
            'technique_id' => 'sometimes|exists:prospect_techniques,id',
            'email' => 'sometimes|email|max:255',
            'service_id' => 'sometimes|exists:services,id',
            'status' => 'sometimes|string|max:255',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'area_input' => 'nullable|string|max:255',
            'representative__id' => 'sometimes|exists:sales__representatives,id',  // double underscore
            'onboarding_date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'contact_name' => 'sometimes|string|max:255',
            'contact_number' => 'sometimes|string|max:20',
            'communication_id' => 'sometimes|exists:ways_of_communication,id'
        ]);

        $performance_plan->update($validated);

        return response()->json([
            'message' => 'Performance plan updated successfully',
            'plan' => $performance_plan->load('user', 'technique', 'service', 'salesRepresentative', 'waysOfCommunication')
        ]);
    }

    public function destroy(PerformancePlan $performance_plan)
    {
        $performance_plan->delete();

        return response()->json([
            'message' => 'Performance plan deleted successfully'
        ]);
    }
}
