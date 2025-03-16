<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('tags')->get();

        // return
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();

        // return
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'type' => 'required|in:mini,personal,corporate',
            'tags' => 'nullable|array',
        ]);

        $project = new Project();
        $project->title = $validated['title'];
        $project->description = $validated['description'];
        $project->github_url = $validated['github_url'] ?? null;
        $project->live_url = $validated['live_url'] ?? null;
        $project->type = $validated['type'];

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('project-images', 'public');
            $project->image_url = $path;
        }

        $project->save();

        // Attach tags if provided
        if (isset($validated['tags'])) {
            $project->tags()->attach($validated['tags']);
        }

        // return
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load('tags');

        // return
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $tags = Tag::all();

        // return
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'type' => 'required|in:mini,personal,corporate',
            'tags' => 'nullable|array',
        ]);

        $project->title = $validated['title'];
        $project->description = $validated['description'];
        $project->github_url = $validated['github_url'] ?? null;
        $project->live_url = $validated['live_url'] ?? null;
        $project->type = $validated['type'];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($project->image_url) {
                Storage::disk('public')->delete($project->image_url);
            }

            $path = $request->file('image')->store('project-images', 'public');
            $project->image_url = $path;
        }

        $project->save();

        // Sync tags if provided
        if (isset($validated['tags'])) {
            $project->tags()->sync($validated['tags']);
        }

        // return
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image_url) {
            Storage::disk('public')->delete($project->image_url);
        }

        $project->delete();

        // return
    }
}
