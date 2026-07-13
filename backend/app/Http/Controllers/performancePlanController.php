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
        // All fields are nullable now — the create form no longer requires
        // anything to be filled in. 'exists' checks are skipped automatically
        // by Laravel when a nullable field is left null.
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'date_recorded' => 'nullable|date',
            'client_name' => 'nullable|string|max:255',
            'technique_id' => 'nullable|exists:prospect_techniques,id',
            'email' => 'nullable|email|max:255',
            'service_id' => 'nullable|exists:services,id',
            'status' => 'nullable|string|max:255',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'area_input' => 'nullable|string|max:255',
            'representative__id' => 'nullable|exists:sales__representatives,id',  // double underscore
            'onboarding_date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'contact_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'communication_id' => 'nullable|exists:ways_of_communication,id'
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
        // 'sometimes' skips validation when the key is absent from the request;
        // 'nullable' alongside it means that when the key IS present, an
        // explicit null is also accepted (not just a valid value).
        $validated = $request->validate([
            'user_id' => 'sometimes|nullable|exists:users,id',
            'date_recorded' => 'sometimes|nullable|date',
            'client_name' => 'sometimes|nullable|string|max:255',
            'technique_id' => 'sometimes|nullable|exists:prospect_techniques,id',
            'email' => 'sometimes|nullable|email|max:255',
            'service_id' => 'sometimes|nullable|exists:services,id',
            'status' => 'sometimes|nullable|string|max:255',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'area_input' => 'nullable|string|max:255',
            'representative__id' => 'sometimes|nullable|exists:sales__representatives,id',  // double underscore
            'onboarding_date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'contact_name' => 'sometimes|nullable|string|max:255',
            'contact_number' => 'sometimes|nullable|string|max:20',
            'communication_id' => 'sometimes|nullable|exists:ways_of_communication,id'
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
