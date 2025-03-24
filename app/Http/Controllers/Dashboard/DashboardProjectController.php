<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Tag;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class DashboardProjectController
 *
 * This controller handles CRUD operations for projects in the dashboard.
 */
class DashboardProjectController extends Controller
{
    protected ImageService $imageService;

    /**
     * DashboardProjectController constructor.
     *
     * @param ImageService $imageService The service for handling image operations.
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->imageService->ensureStorageLink();
    }

    /**
     * Display a listing of the projects.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Project::with(['tags', 'getViewsCount', 'getLikesCount'])->get());
    }

    /**
     * Store a newly created project in storage.
     *
     * @param Request $request The request instance containing the project data.
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());
        $project = $this->saveProject(new Project(), $validated, $request);

        return response()->json($project, 201);
    }

    /**
     * Display the specified project.
     *
     * @param Project $project The project instance to display.
     * @return JsonResponse
     */
    public function show(Project $project)
    {
        $project->load('tags');
        return response()->json($project);
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param Project $project The project instance to edit.
     * @return JsonResponse
     */
    public function edit(Project $project)
    {
        return response()->json([
            'project' => $project,
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Update the specified project in storage.
     *
     * @param Request $request The request instance containing the updated project data.
     * @param Project $project The project instance to update.
     * @return JsonResponse
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate($this->getValidationRules());
        $project = $this->saveProject($project, $validated, $request);

        return response()->json($project);
    }

    /**
     * Remove the specified project from storage.
     *
     * @param Project $project The project instance to delete.
     * @return JsonResponse
     */
    public function destroy(Project $project)
    {
        if ($project->image_url) {
            $this->imageService->delete($project->image_url);
        }

        $project->delete();
        return response()->json(null, 204);
    }

    /**
     * Get the validation rules for storing and updating projects.
     *
     * @return array The validation rules.
     */
    private function getValidationRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'type' => 'required|in:mini,personal,corporate,professional,open-source',
            'tags' => 'nullable|array|exists:tags,id',
        ];
    }

    /**
     * Save the project instance with the validated data.
     *
     * @param Project $project The project instance to save.
     * @param array $validated The validated data.
     * @param Request $request The request instance containing the project data.
     * @return Project The saved project instance.
     */
    private function saveProject(Project $project, array $validated, Request $request): Project
    {
        // Set basic properties
        $project->title = $validated['title'];
        $project->description = $validated['description'];
        $project->github_url = $validated['github_url'] ?? null;
        $project->live_url = $validated['live_url'] ?? null;
        $project->type = $validated['type'];

        // Handle image upload
        if ($request->hasFile('image')) {
            $idForFilename = $project->exists ? $project->id : (string) Str::uuid();
            $project->image_url = $this->imageService->update(
                $request->file('image'),
                $project->image_url,
                'project',
                $idForFilename
            );
        }

        $project->save();

        // Handle tags
        if (isset($validated['tags'])) {
            $project->tags()->sync($validated['tags']);
        }

        return $project;
    }
}
