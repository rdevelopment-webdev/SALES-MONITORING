<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of all pages.
     */
    public function index()
    {
        $pages = Page::with('Role_Page_Permission')->get();

        return response()->json([
            'message' => 'Pages retrieved successfully',
            'data' => $pages
        ]);
    }

    /**
     * Store a newly created page.
     */
    public function store(Request $request)
    {
        $request->validate([
            'page_name' => 'required|string|max:255|unique:pages,page_name',
        ]);

        $page = Page::create([
            'page_name' => $request->page_name,
        ]);

        return response()->json([
            'message' => 'Page created successfully',
            'data' => $page
        ], 201);
    }

    /**
     * Display the specified page.
     */
    public function show(Page $page)
    {
        $page->load('Role_Page_Permission');

        return response()->json([
            'message' => 'Page retrieved successfully',
            'data' => $page
        ]);
    }

    /**
     * Update the specified page.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'page_name' => 'required|string|max:255|unique:pages,page_name,' . $page->id,
        ]);

        $page->update([
            'page_name' => $request->page_name,
        ]);

        return response()->json([
            'message' => 'Page updated successfully',
            'data' => $page
        ]);
    }

    /**
     * Remove the specified page.
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return response()->json([
            'message' => 'Page deleted successfully'
        ]);
    }
}
