<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AuditLogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = AuditLog::with(['user', 'archive']);

        // Correct: access inputs as properties or via input()
        if ($request->has('user_id')) {
            $query->where('user_id', $request->input('user_id')); // or $request->user_id
        }

        if ($request->has('action')) {
            $query->where('action', 'like', '%' . $request->input('action') . '%');
        }

        if ($request->has('from') && $request->has('to')) {
            $query->whereBetween('time_log', [$request->input('from'), $request->input('to')]);
        }

        $auditLogs = $query->orderByDesc('time_log')->paginate(15);

        return response()->json($auditLogs);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'time_log' => 'required|date',
            'action'   => 'required|string|max:255',
            'user_id'  => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $auditLog = AuditLog::create($validator->validated());

        return response()->json([
            'message' => 'Audit log created successfully',
            'data'    => $auditLog->load(['user', 'archive']),
        ], 201);
    }

    public function show(AuditLog $auditLog): JsonResponse
    {
        return response()->json($auditLog->load(['user', 'archive']));
    }

    public function update(Request $request, AuditLog $auditLog): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'time_log' => 'sometimes|date',
            'action'   => 'sometimes|string|max:255',
            'user_id'  => 'sometimes|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $auditLog->update($validator->validated());

        return response()->json([
            'message' => 'Audit log updated successfully',
            'data'    => $auditLog->fresh(['user', 'archive']),
        ]);
    }

    public function destroy(AuditLog $auditLog): JsonResponse
    {
        $auditLog->delete();

        return response()->json([
            'message' => 'Audit log deleted successfully',
        ]);
    }

    public function byUser(User $user): JsonResponse
    {
        $logs = $user->auditLogs()
            ->with('archive')
            ->orderByDesc('time_log')
            ->paginate(15);

        return response()->json($logs);
    }
}
