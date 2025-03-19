<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, $id)
    {
        $user = auth()->user(); // Get the logged-in user
        $modelType = $request->get('type'); // Determine which model (project, course, material)
        $likeable = $modelType::findOrFail($id); // Find the model by ID

        // Check if the user has already liked the entity
        $existingLike = $likeable->likes()->where('user_id', $user->id)->first();

        if (!$existingLike) {
            // Create a new like
            $likeable->likes()->create(['user_id' => $user->id]);
        }

        return response()->json([
            'message' => 'Liked successfully',
            'likes_count' => $likeable->getLikesCount(),
        ]);
    }

}
