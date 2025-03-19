<?php

namespace App\Http\Controllers;

use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function view(Request $request, $id)
    {
        $modelType = $request->get('type'); // Determine which model (project, course, material)
        $viewable = $modelType::findOrFail($id); // Find the model by ID

        // Log the view (can track by user if needed)
        View::create([
            'viewable_id' => $viewable->id,
            'viewable_type' => get_class($viewable), // The type (Project, Course, etc.)
            'user_id' => auth()->id(), // Optional: track which user viewed
        ]);

        return response()->json([
            'message' => 'View logged',
            'views_count' => $viewable->getViewsCount(),
        ]);
    }

}
