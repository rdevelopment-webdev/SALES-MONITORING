<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    private function formatLead(Lead $lead): array
    {
        $lead->loadMissing('industry');

        return [
            'id' => $lead->id,
            'date' => optional($lead->created_at)->format('m/d/y'),
            'businessName' => $lead->business_name,
            'contactPerson' => $lead->contact_person,
            'jobPosition' => $lead->job_position,
            'contactNo' => $lead->contact_number,
            'email' => $lead->email,
            'service' => $lead->service_name,
            'status' => $lead->status_name,
            'statusPercent' => $lead->status_percent,
            'remarks' => $lead->remarks,
            'location' => $lead->location,
            'industry' => $lead->industry?->industry_name,
            'industryId' => $lead->industry_id,
            'archivedDate' => optional($lead->archived_at)->format('M j, Y'),
        ];
    }



    private function normalizeInput(Request $request): array
    {
        $data = $request->all();

        $map = [
            'businessName' => 'business_name',
            'contactPerson' => 'contact_person',
            'jobPosition' => 'job_position',
            'contactNo' => 'contact_number',
            'contact_no' => 'contact_number',
            'contactNumber' => 'contact_number',
            'userId' => 'user_id',
            'service' => 'service_name',
            'status' => 'status_name',
            'industryId' => 'industry_id',
        ];

        foreach ($map as $from => $to) {
            if (array_key_exists($from, $data) && !array_key_exists($to, $data)) {
                $data[$to] = $data[$from];
            }
        }

        if (!isset($data['user_id']) && $request->user()) {
            $data['user_id'] = $request->user()->id;
        }

        return $data;
    }

    public function index()
    {
        $query = Lead::active()->with(['user', 'industry']);

        if (request('location')) {
            $query->whereRaw('LOWER(location) = ?', [strtolower(request('location'))]);
        }

        if (request('industry')) {
            $query->whereHas('industry', function ($industryQuery) {
                $industryQuery->where('industry_name', request('industry'));
            });
        }

        if (request('service')) {
            $query->where('service_name', request('service'));
        }

        if (request('status')) {
            $query->where('status_name', request('status'));
        }

        if (request('date')) {
            $date = request('date');

            if (preg_match('/^\d{2}\/\d{2}\/\d{2}$/', $date)) {
                $date = \DateTime::createFromFormat('m/d/y', $date)?->format('Y-m-d');
            }

            if ($date) {
                $query->whereDate('created_at', $date);
            }
        }

        if (request('search')) {
            $search = request('search');
            $query->where(function ($searchQuery) use ($search) {
                $searchQuery
                    ->where('business_name', 'like', "%{$search}%")
                    ->orWhere('contact_person', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $leads = $query->latest()->get()->map(fn (Lead $lead) => $this->formatLead($lead));

        return response()->json($leads);
    }

    public function store(Request $request)
{
    $input = $this->normalizeInput($request);
    $input['status_name'] = $input['status_name'] ?? 'Prospect';
    $input['status_percent'] = $input['progress'] ?? 0;

    $validated = validator($input, [
        'user_id' => 'required|exists:users,id',
        'industry_id' => 'required|exists:industries,id',
        'business_name' => 'nullable|string|max:255',
        'contact_person' => 'required|string|max:255',
        'job_position' => 'nullable|string|max:255',
        'contact_number' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'service_name' => 'nullable|string|max:255',
        'status_name' => 'required|string|max:255',
        'status_percent' => 'required|integer|min:0|max:100',
        'remarks' => 'nullable|string',
        'location' => 'required|string',
    ])->validate();

    $lead = Lead::create($validated);

    AuditLog::create([
        'user_id' => auth()->id() ?? $validated['user_id'],
        'time_log' => now(),
        'action' => 'Created lead: ' . $lead->business_name,
    ]);

    return response()->json([
        'message' => 'Lead created successfully',
        ...$this->formatLead($lead),
    ], 201);
}

    public function show(Lead $lead)
    {
        return response()->json($lead->load('user'));
    }

    public function update(Request $request, Lead $lead)
    {
        $input = $this->normalizeInput($request);

        if (array_key_exists('progress', $input) && !array_key_exists('status_percent', $input)) {
            $input['status_percent'] = $input['progress'];
        }

        $validated = validator($input, [
            'user_id' => 'sometimes|exists:users,id',
            'industry_id' => 'sometimes|exists:industries,id',
            'business_name' => 'sometimes|nullable|string|max:255',
            'contact_person' => 'sometimes|required|string|max:255',
            'job_position' => 'nullable|string|max:255',
            'contact_number' => 'sometimes|required|string|max:20',
            'email' => 'nullable|email|max:255',
            'service_name' => 'sometimes|nullable|string|max:255',
            'status_name' => 'sometimes|string|max:255',
            'status_percent' => 'sometimes|integer|min:0|max:100',
            'remarks' => 'nullable|string',
            'location' => 'sometimes|required|string',
        ])->validate();

        $lead->update($validated);

        $actorId = auth()->id() ?? $lead->user_id;

        AuditLog::create([
            'user_id' => $actorId,
            'time_log' => now(),
            'action' => 'Updated lead: ' . $lead->business_name
        ]);

        return response()->json([
            'message' => 'Lead updated successfully',
            'lead' => $this->formatLead($lead),
            ...$this->formatLead($lead),
        ]);
    }

    public function archived(Request $request)
    {
        $query = Lead::archived()->with('industry');

        if ($request->query('location')) {
            $query->whereRaw('LOWER(location) = ?', [strtolower($request->query('location'))]);
        }

        $leads = $query->latest('archived_at')->get()->map(fn (Lead $lead) => $this->formatLead($lead));

        return response()->json($leads);
    }

    public function archiveBatch(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:leads,id',
        ]);

        Lead::whereIn('id', $validated['ids'])->get()->each->archive();

        return response()->json(['message' => 'Leads archived successfully']);
    }

    public function archiveSelected(Request $request)
    {
        return $this->archiveBatch($request);
    }

    public function restore(Lead $lead)
    {
        $lead->unarchive();

        return response()->json($this->formatLead($lead));
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return response()->json([
            'message' => 'Lead deleted successfully'
        ]);
    }

}
