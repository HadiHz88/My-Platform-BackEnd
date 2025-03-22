<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Blog $blog)
    {
        $comments = $blog->comments;

        return json_encode($comments);
    }

    public function store(Request $request, Blog $blog)
    {
        $comment = $request->validate([
            'body' => 'required|string'
        ]);

        $blog->comments()->create([$comment]);

        return json_encode($blog->comments);
    }
}
