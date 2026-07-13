<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Industry;

class IndustryController extends Controller
{
    public function index()
    {
        $industries = Industry::active()->with('leads')->get();

        return response()->json([
            'message' => 'Industries retrieved successfully',
            'data' => $industries
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if (isset($input['name']) && !isset($input['industry_name'])) {
            $input['industry_name'] = $input['name'];
        }

        $validated = validator($input, [
            'industry_name' => 'required|string|max:255|unique:industries,industry_name',
        ])->validate();

        $industry = Industry::create($validated);

        return response()->json([
            'message' => 'Industry created successfully',
            'data' => $industry
        ], 201);
    }

    public function show(Industry $industry)
    {
        return response()->json([
            'message' => 'Industry retrieved successfully',
            'data' => $industry->load('leads')
        ]);
    }

    public function update(Request $request, Industry $industry)
    {
        $validated = $request->validate([
            'industry_name' => 'sometimes|string|max:255|unique:industries,industry_name,' . $industry->id,
        ]);

        $industry->update($validated);

        return response()->json([
            'message' => 'Industry updated successfully',
            'data' => $industry
        ]);
    }

    public function destroy(Industry $industry)
    {
        $industry->delete();

        return response()->json([
            'message' => 'Industry deleted successfully'
        ]);
    }
}
