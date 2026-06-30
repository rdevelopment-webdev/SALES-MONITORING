<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $service = Service::with('performancePlans')->get();  // FIX: match relationship method name

        return response()->json([
            'message' => 'Services retrieved successfully',
            'data' => $service
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255|unique:services,service_name',
        ]);

        $service = Service::create($validated);  // FIX: use validated array

        return response()->json([
            'message' => 'Service created successfully',
            'service' => $service
        ], 201);
    }

    public function show(Service $service)
    {
        return response()->json([
            'message' => 'Service retrieved successfully',
            'data' => $service->load('performancePlans')  // FIX: eager load with correct name
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'service_name' => 'sometimes|string|max:255|unique:services,service_name,' . $service->id,
        ]);

        $service->update($validated);  // FIX: use validated array

        return response()->json([
            'message' => 'Service updated successfully',
            'data' => $service
        ]);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully' 
        ]);
    }
}