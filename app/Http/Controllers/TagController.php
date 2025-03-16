<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::withCount('projects')->get();

        // return
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags',
            'color' => 'nullable|string|max:50',
        ]);

        $tag = Tag::create($validated);

        // return
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $projects = $tag->projects()->get();

        // return
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        // return
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'color' => 'nullable|string|max:50',
        ]);

        $tag->update($validated);

        // return
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // This will automatically detach the tag from all projects
        // due to the cascade delete in the migration
        $tag->delete();

        // return
    }
}
