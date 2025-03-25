<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Tag;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class DashboardBlogController
 *
 * This controller handles CRUD operations for blogs in the dashboard.
 */
class DashboardBlogController extends Controller
{
    protected ImageService $imageService;

    /**
     * DashboardBlogController constructor.
     *
     * @param ImageService $imageService The service for handling image storage operations.
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
    public function index(): JsonResponse
    {
        return response()->json(Blog::with(['tags'])->get());
    }

    /**
     * Store a newly created blog in storage.
     *
     * @param BlogRequest $request The request instance containing the blog data.
     * @return JsonResponse
     */
    public function store(BlogRequest $request): JsonResponse
    {
        $blog = $this->saveBlog(new Blog(), $request);

        return response()->json([
            'message' => 'Blog created successfully.',
        ], 201);
    }

    /**
     * Save the blog instance with the provided data.
     *
     * @param Blog $blog The blog instance to save.
     * @param BlogRequest $request The request instance containing the blog data.
     * @return Blog The saved blog instance.
     */
    private function saveBlog(Blog $blog, BlogRequest $request): Blog
    {
        $validated = $request->validated();

        $blog->title = $validated['title'];
        $blog->body = $validated['body'];

        if ($request->hasFile('image')) {
            $idForFilename = $blog->exists ? $blog->id : (string)Str::uuid();
            $blog->image_url = $this->imageService->update(
                $request->file('image'),
                $blog->image_url,
                'blog',
                $idForFilename
            );
        }

        $blog->save();

        if (isset($validated['tags'])) {
            $blog->tags()->sync($validated['tags']);
        }

        return $blog;
    }

    /**
     * Update the specified blog in storage.
     *
     * @param BlogRequest $request The request instance containing the updated blog data.
     * @param Blog $blog The blog instance to update.
     * @return JsonResponse
     */
    public function update(BlogRequest $request, Blog $blog): JsonResponse
    {
        $blog = $this->saveBlog($blog, $request);

        return response()->json([
            'message' => 'Blog updated successfully.',
        ]);
    }

    /**
     * Display the specified blog.
     *
     * @param Blog $blog The blog instance to display.
     * @return JsonResponse
     */
    public function show(Blog $blog): JsonResponse
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
    public function edit(Blog $blog): JsonResponse
    {
        return response()->json([
            'blog' => $blog,
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Remove the specified blog from storage.
     *
     * @param Blog $blog The blog instance to delete.
     * @return JsonResponse
     */
    public function destroy(Blog $blog): JsonResponse
    {
        if ($blog->image_url) {
            $this->imageService->delete($blog->image_url);
        }

        $blog->delete();

        return response()->json([
            'message' => 'Blog deleted successfully.',
        ], 204);
    }
}
