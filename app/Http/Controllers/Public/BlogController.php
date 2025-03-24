<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class BlogController
 *
 * This controller handles the retrieval of blog data.
 * It provides methods to list all blogs and to show a specific blog with its associated tags and comments.
 */
class BlogController extends Controller
{
    /**
     * Display a listing of the blogs.
     *
     * @return JsonResponse
     */
    public function index(){
        return response()->json(Blog::with(['tags', 'comments'])->get());
    }

    /**
     * Display the specified blog.
     *
     * @param Blog $blog The blog instance to display.
     * @return JsonResponse
     */
    public function show(Blog $blog){
        return response()->json($blog->load(['tags', 'comments']));
    }
}
