<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Services\MaterialStoringService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class DashboardMaterialController
 *
 * This controller handles CRUD operations for materials in the dashboard.
 */
class DashboardMaterialController extends Controller
{
    protected MaterialStoringService $materialService;

    /**
     * DashboardMaterialController constructor.
     *
     * @param MaterialStoringService $materialService The service for handling material storage operations.
     */
    public function __construct(MaterialStoringService $materialService)
    {
        $this->materialService = $materialService;
        $this->materialService->ensureStorageLink();
    }

    /**
     * Display a listing of the materials.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Material::with('course')->get());
    }

    /**
     * Store a newly created material in storage.
     *
     * @param Request $request The request instance containing the material data.
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());
        $material = new Material($validated);

        if ($request->hasFile('file')) {
            $material->url = $this->materialService->store(
                $request->file('file'),
                $validated['course_id'],
                $validated['type']
            );
        }

        $material->save();

        return response()->json($material, 201);
    }

    /**
     * Get the validation rules for storing and updating materials.
     *
     * @return array The validation rules.
     */
    private function getValidationRules(): array
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'language' => 'required|in:en,fr,ar',
            'type' => 'required|in:video,image,pdf,link,code,markdown,other',
            'file' => 'nullable|file|max:10240',
        ];
    }

    /**
     * Display the specified material.
     *
     * @param Material $material The material instance to display.
     * @return JsonResponse
     */
    public function show(Material $material)
    {
        return response()->json($material);
    }

    /**
     * Update the specified material in storage.
     *
     * @param Request $request The request instance containing the updated material data.
     * @param Material $material The material instance to update.
     * @return JsonResponse
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate($this->getValidationRules());

        if ($request->hasFile('file')) {
            $material->url = $this->materialService->update(
                $request->file('file'),
                $material->url,
                $validated['course_id'],
                $validated['type']
            );
        }

        $material->update($validated);

        return response()->json($material);
    }

    /**
     * Remove the specified material from storage.
     *
     * @param Material $material The material instance to delete.
     * @return JsonResponse
     */
    public function destroy(Material $material)
    {
        if ($material->url) {
            $this->materialService->delete($material->url);
        }

        $material->delete();

        return response()->json(null, 204);
    }
}
