<?php

namespace App\Http\Controllers;

use App\Models\Archive;
// use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        $archives = Archive::with(['lead', 'auditLog'])->get();
        return response()->json($archives);
    }

    public function show(Archive $archive)
    {
        return response()->json($archive->load('lead', 'auditLog'));
    }

    public function destroy(Archive $archive)
    {
        $archive->delete();
        return response()->json([
            'message' => 'Archive permanently deleted'
        ]);
    }
}
