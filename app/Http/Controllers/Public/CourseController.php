<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\JsonResponse;

/**
 * Class CourseController
 *
 * This controller handles the retrieval of course data.
 * It provides methods to list all courses and to show a specific course with its associated tags and materials.
 */
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Course::with(['tags','materials']));
    }

    /**
     * Display the specified resource.
     *
     * @param Course $course The course instance to display.
     * @return JsonResponse
     */
    public function show(Course $course)
    {
        return response()->json($course->load(['tags','materials']));
    }
}
