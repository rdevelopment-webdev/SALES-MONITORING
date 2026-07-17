<?php

namespace App\Http\Controllers;

use App\Models\PerformancePlan;
use Illuminate\Http\Request;

class PerformancePlanController extends Controller
{
    public function index()
    {
        $plans = PerformancePlan::whereNull('archived_at')
            ->with('user', 'technique', 'service', 'salesRepresentatives', 'waysOfCommunication')
            ->get();
        return response()->json($plans);
    }

    public function archived()
    {
        $plans = PerformancePlan::whereNotNull('archived_at')
            ->with('user', 'technique', 'service', 'salesRepresentatives', 'waysOfCommunication')
            ->orderByDesc('archived_at')
            ->get();
        return response()->json($plans);
    }

    public function store(Request $request)
    {
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
            'sales_representative_ids' => 'nullable|array',
            'sales_representative_ids.*' => 'exists:sales__representatives,id',
            'onboarding_date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'contact_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'communication_id' => 'nullable|exists:ways_of_communication,id',
        ]);

        $repIds = $validated['sales_representative_ids'] ?? [];
        unset($validated['sales_representative_ids']);

        $plan = PerformancePlan::create($validated);

        if (!empty($repIds)) {
            $plan->salesRepresentatives()->sync($repIds);
        }

        return response()->json([
            'message' => 'Performance plan created successfully',
            'plan' => $plan->load('user', 'technique', 'service', 'salesRepresentatives', 'waysOfCommunication'),
        ], 201);
    }

    public function show(PerformancePlan $performance_plan)
    {
        return response()->json(
            $performance_plan->load('user', 'technique', 'service', 'salesRepresentatives', 'waysOfCommunication')
        );
    }

    public function update(Request $request, PerformancePlan $performance_plan)
    {
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
            'sales_representative_ids' => 'sometimes|nullable|array',
            'sales_representative_ids.*' => 'exists:sales__representatives,id',
            'onboarding_date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'contact_name' => 'sometimes|nullable|string|max:255',
            'contact_number' => 'sometimes|nullable|string|max:20',
            'communication_id' => 'sometimes|nullable|exists:ways_of_communication,id',
        ]);

        // sync() runs separately from the plan's own column update, since
        // sales_representative_ids lives in a pivot table, not a column
        // on performanceplans.
        $repIdsProvided = array_key_exists('sales_representative_ids', $validated);
        $repIds = $validated['sales_representative_ids'] ?? [];
        unset($validated['sales_representative_ids']);

        $performance_plan->update($validated);

        if ($repIdsProvided) {
            // sync() with an empty array clears all reps — matches the
            // "sometimes|nullable" semantics used elsewhere in this payload.
            $performance_plan->salesRepresentatives()->sync($repIds ?? []);
        }

        return response()->json([
            'message' => 'Performance plan updated successfully',
            'plan' => $performance_plan->load('user', 'technique', 'service', 'salesRepresentatives', 'waysOfCommunication'),
        ]);
    }

    public function destroy(PerformancePlan $performance_plan)
    {
        $performance_plan->delete();

        return response()->json([
            'message' => 'Performance plan deleted successfully',
        ]);
    }
}