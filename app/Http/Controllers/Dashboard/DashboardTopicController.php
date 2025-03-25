<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Topic;
use Illuminate\Http\Request;

class DashboardTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $chapters = $course->topics()->get();
        return response()->json($chapters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $chapter = $course->topics()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'order' => $request->input('order', 0)
        ]);

        return response()->json($chapter, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        $topic->load(['materials']);

        return response()->json($topic);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $topic->update($validatedData);

        return response()->json($topic);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();

        return response()->json([
            'message' => 'Topic deleted successfully.',
        ]);
    }
}
