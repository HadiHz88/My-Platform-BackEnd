<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Tag;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class DashboardCourseController
 * Handles CRUD operations for courses in the dashboard.
 */
class DashboardCourseController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->imageService->ensureStorageLink();
    }

    /**
     * Display a listing of the courses.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Course::with(['tags', 'materials'])->get());
    }

    /**
     * Store a newly created course in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());
        $course = $this->saveCourse(new Course(), $validated, $request);

        return response()->json($course, 201);
    }

    /**
     * Display the specified course.
     *
     * @param Course $course
     * @return JsonResponse
     */
    public function show(Course $course)
    {
        $course->load(['tags', 'materials']);
        return response()->json($course);
    }

    /**
     * Update the specified course in storage.
     *
     * @param Request $request
     * @param Course $course
     * @return JsonResponse
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate($this->getValidationRules());
        $course = $this->saveCourse($course, $validated, $request);

        return response()->json($course);
    }

    /**
     * Remove the specified course from storage.
     *
     * @param Course $course
     * @return JsonResponse
     */
    public function destroy(Course $course)
    {
        if ($course->image) {
            $this->imageService->delete($course->image);
        }
        $course->delete();
        return response()->json(null, 204);
    }

    /**
     * Get validation rules for storing and updating courses.
     *
     * @return array
     */
    private function getValidationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code',
            'difficulty' => 'required|in:easy,normal,hard',
            'semester' => 'required|integer|min:1',
            'credits' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|array|exists:tags,id',
        ];
    }

    /**
     * Save the course instance with the validated data.
     *
     * @param Course $course
     * @param array $validated
     * @param Request $request
     * @return Course
     */
    private function saveCourse(Course $course, array $validated, Request $request): Course
    {
        $course->fill($validated);

        // Handle image upload
        if ($request->hasFile('image')) {
            $idForFilename = $course->exists ? $course->id : (string) Str::uuid();
            $course->image = $this->imageService->update(
                $request->file('image'),
                $course->image,
                'course',
                $idForFilename
            );
        }

        $course->save();

        // Handle tags
        if (isset($validated['tags'])) {
            $course->tags()->sync($validated['tags']);
        }

        return $course;
    }
}
