<?php

namespace App\Http\Controllers;

use App\Models\SalesRepresentative;
use Illuminate\Http\Request;

class SalesRepresentativeController extends Controller
{
    public function index()
    {
        $representatives = SalesRepresentative::with('performancePlans')->get();  // FIX: match relationship method name

        return response()->json([
            'message' => 'Sales representatives retrieved successfully',
            'data' => $representatives
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'representative_name' => 'required|string|max:255|unique:sales__representatives,representative_name',
        ]);

        $representative = SalesRepresentative::create($validated);  // FIX: use validated array

        return response()->json([
            'message' => 'Sales representative created successfully',
            'representative' => $representative
        ], 201);
    }

    public function show(SalesRepresentative $salesRepresentative) 
    {
         return response()->json([
            'message' => 'Sales representative retrieved successfully',
            'data' => $salesRepresentative->load('performancePlans')  // FIX: eager load with correct name
        ]);
    }

    public function update(Request $request, SalesRepresentative $salesRepresentative)
    {
        $validated = $request->validate([
            'representative_name' => 'sometimes|string|max:255|unique:sales__representatives,representative_name,' . $salesRepresentative->id,
        ]);

        $salesRepresentative->update($validated);  // FIX: use validated array

        return response()->json([
            'message' => 'Sales representative updated successfully',
            'data' => $salesRepresentative
        ]);
    }

    public function destroy(SalesRepresentative $salesRepresentative)
    {
        $salesRepresentative->delete();

        return response()->json([
            'message' => 'Sales representative deleted successfully'
        ]);
    }
}