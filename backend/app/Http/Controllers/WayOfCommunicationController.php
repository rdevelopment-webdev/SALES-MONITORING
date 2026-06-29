<?php

namespace App\Http\Controllers;

use App\Models\Way_of_Communication as WayOfCommunication;
use Illuminate\Http\Request;

class WayOfCommunicationController extends Controller
{
    public function index()
    {
        $wayOfCommunication = WayOfCommunication::with('performancePlans')->get();  // FIX: match relationship method name

        return response()->json([
            'message' => 'Ways of communication retrieved successfully',
            'data' => $wayOfCommunication
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'communication_name' => 'required|string|max:255|unique:ways_of_communication,communication_name',
        ]);

        $wayOfCommunication = WayOfCommunication::create($validated);  // FIX: use validated array

        return response()->json([
            'message' => 'Way of communication created successfully',
            'data' => $wayOfCommunication
        ], 201);
    }

    public function show(WayOfCommunication $wayOfCommunication)
    {
        return response()->json([
            'message' => 'Way of communication retrieved successfully',
            'data' => $wayOfCommunication->load('performancePlans')  // FIX: eager load with correct name
        ]);
    }

    public function update(Request $request, WayOfCommunication $wayOfCommunication)
    {
        $validated = $request->validate([
            'communication_name' => 'sometimes|string|max:255|unique:ways_of_communication,communication_name,' . $wayOfCommunication->id,
        ]);

        $wayOfCommunication->update($validated);  // FIX: use validated array

        return response()->json([
            'message' => 'Way of communication updated successfully',
            'data' => $wayOfCommunication
        ]);
    }

    public function destroy(WayOfCommunication $wayOfCommunication)
    {
        $wayOfCommunication->delete();

        return response()->json([
            'message' => 'Way of communication deleted successfully'
        ]);
    }
}