<?php

namespace App\Http\Controllers;

use App\Models\ProspectTechnique;
use Illuminate\Http\Request;

class ProspectTechniqueController extends Controller
{
    public function index()
    {
        $techniques = ProspectTechnique::with('performancePlans')->get();  // FIX: match relationship method name

        return response()->json([
            'message' => 'Prospect techniques retrieved successfully',
            'data' => $techniques
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'technique_name' => 'required|string|max:255|unique:prospect_techniques,technique_name',
        ]);

        $technique = ProspectTechnique::create($validated);  // FIX: use validated array

        return response()->json([
            'message' => 'Prospect technique created successfully',
            'technique' => $technique
        ], 201);
    }

    public function show(ProspectTechnique $prospectTechnique)
    {
        return response()->json([
            'message' => 'Prospect technique retrieved successfully',
            'data' => $prospectTechnique->load('performancePlans')  // FIX: eager load with correct name
        ]);
    }

    public function update(Request $request, ProspectTechnique $prospectTechnique)
    {
        $validated = $request->validate([
            'technique_name' => 'sometimes|string|max:255|unique:prospect_techniques,technique_name,' . $prospectTechnique->id,
        ]);

        $prospectTechnique->update($validated);  // FIX: use validated array

        return response()->json([
            'message' => 'Prospect technique updated successfully',
            'data' => $prospectTechnique
        ]);
    }

    public function destroy(ProspectTechnique $prospectTechnique)
    {
        $prospectTechnique->delete();

        return response()->json([
            'message' => 'Prospect technique deleted successfully'
        ]);
    }
}