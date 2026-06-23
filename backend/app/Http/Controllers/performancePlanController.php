<?php

namespace App\Http\Controllers;

use App\Models\PerformancePlan;
use Illuminate\Http\Request;

class PerformancePlanController extends Controller
{
    public function index()
    {
        $plans = PerformancePlan::with('user')->get();
        return response()->json($plans);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'date_recorded' => 'required|date',
            'client_name' => 'required|string|max:255',
            'technique_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'service_name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'area_input' => 'nullable|string|max:255',
            'sales_representative' => 'required|string|max:255',
            'onboarding_date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'contact_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'ways_of_communication' => 'required|string|max:255'
        ]);

        $plan = PerformancePlan::create($validated);

        return response()->json([
            'message' => 'Performance plan created successfully',
            'plan' => $plan
        ], 201);
    }

    public function show(PerformancePlan $performancePlan)
    {
        return response()->json($performancePlan->load('user'));
    }

    public function update(Request $request, PerformancePlan $performancePlan)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,user_id',
            'date_recorded' => 'sometimes|date',
            'client_name' => 'sometimes|string|max:255',
            'technique_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'service_name' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|max:255',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'area_input' => 'nullable|string|max:255',
            'sales_representative' => 'sometimes|string|max:255',
            'onboarding_date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'contact_name' => 'sometimes|string|max:255',
            'contact_number' => 'sometimes|string|max:20',
            'ways_of_communication' => 'sometimes|string|max:255'
        ]);

        $performancePlan->update($validated);

        return response()->json([
            'message' => 'Performance plan updated successfully',
            'plan' => $performancePlan
        ]);
    }

    public function destroy(PerformancePlan $performancePlan)
    {
        $performancePlan->delete();

        return response()->json([
            'message' => 'Performance plan deleted successfully'
        ]);
    }
}
