<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Tag;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class DashboardBlogController
 *
 * Handles CRUD operations for blogs in the dashboard.
 */
class DashboardBlogController extends Controller
{
    protected ImageService $imageService;

    /**
     * DashboardBlogController constructor.
     *
     * @param ImageService $imageService The service for handling image operations.
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->imageService->ensureStorageLink();
    }

    /**
     * Display a listing of the blogs.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Blog::with(['tags', 'comments'])->get());
    }

    /**
     * Store a newly created blog in storage.
     *
     * @param Request $request The request instance containing the blog data.
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());
        $blog = $this->saveBlog(new Blog(), $validated, $request);

        return response()->json($blog, 201);
    }

    /**
     * Display the specified blog.
     *
     * @param Blog $blog The blog instance to display.
     * @return JsonResponse
     */
    public function show(Blog $blog)
    {
        $blog->load(['tags', 'comments']);
        return response()->json($blog);
    }

    /**
     * Show the form for editing the specified blog.
     *
     * @param Blog $blog The blog instance to edit.
     * @return JsonResponse
     */
    public function edit(Blog $blog)
    {
        return response()->json([
            'blog' => $blog,
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Update the specified blog in storage.
     *
     * @param Request $request The request instance containing the updated blog data.
     * @param Blog $blog The blog instance to update.
     * @return JsonResponse
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate($this->getValidationRules());
        $blog = $this->saveBlog($blog, $validated, $request);

        return response()->json($blog);
    }

    /**
     * Remove the specified blog from storage.
     *
     * @param Blog $blog The blog instance to delete.
     * @return JsonResponse
     */
    public function destroy(Blog $blog)
    {
        if ($blog->image_url) {
            $this->imageService->delete($blog->image_url);
        }

        $blog->delete();
        return response()->json(null, 204);
    }

    /**
     * Get the validation rules for storing and updating blogs.
     *
     * @return array The validation rules.
     */
    private function getValidationRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|array|exists:tags,id',
        ];
    }

    /**
     * Save the blog instance with the validated data.
     *
     * @param Blog $blog The blog instance to save.
     * @param array $validated The validated data.
     * @param Request $request The request instance containing the blog data.
     * @return Blog The saved blog instance.
     */
    private function saveBlog(Blog $blog, array $validated, Request $request): Blog
    {
        // Set basic properties
        $blog->title = $validated['title'];
        $blog->body = $validated['body'];

        // Handle image upload
        if ($request->hasFile('image')) {
            $idForFilename = $blog->exists ? $blog->id : (string) Str::uuid();
            $blog->image_url = $this->imageService->update(
                $request->file('image'),
                $blog->image_url,
                'blog',
                $idForFilename
            );
        }

        $blog->save();

        // Handle tags
        if (isset($validated['tags'])) {
            $blog->tags()->sync($validated['tags']);
        }

        return $blog;
    }
}
