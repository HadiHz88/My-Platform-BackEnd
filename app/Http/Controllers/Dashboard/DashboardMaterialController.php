<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\Material;
use App\Services\MaterialService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DashboardMaterialController extends Controller
{
    protected MaterialService $materialService;

    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
        $this->materialService->ensureStorageLink();
    }

    /**
     * Store a new material for a specific topic
     */
    public function store(Request $request, Topic $topic)
    {
        $validated = $request->validate($this->getValidationRules($topic->id));
        $material = $this->saveMaterial(new Material(), $validated, $request, $topic);

        return response()->json($material, 201);
    }

    /**
     * Update an existing material
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate($this->getValidationRules($material->topic_id, $material->id));
        $material = $this->saveMaterial($material, $validated, $request, $material->topic);

        return response()->json($material, 200);
    }

    /**
     * Validation rules for material
     */
    private function getValidationRules(int $topicId, ?int $materialId = null): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'language' => 'required|in:en,fr,ar',
            'type' => 'required|in:video,image,pdf,link,code,markdown,other',
            'order' => 'nullable|integer',
            'file' => [
                Rule::requiredIf(fn () => !$materialId), // only required for new materials
                'nullable',
                'max:20480', // 20MB max
                Rule::when(
                    $this->materialService->isFileUploadType($request->input('type')),
                    [
                        'file',
                        $this->materialService->getFileValidationRule($request->input('type'))
                    ]
                )
            ],
            'url' => [
                Rule::requiredIf(fn () => $this->materialService->isLinkType($request->input('type'))),
                'nullable',
                'url'
            ]
        ];
    }

    /**
     * Save material data and handle file/link upload
     */
    private function saveMaterial(Material $material, array $validated, Request $request, Topic $topic): Material
    {
        $material->fill([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'language' => $validated['language'],
            'type' => $validated['type'],
            'topic_id' => $topic->id,
            'order' => $validated['order'] ?? 0
        ]);

        // Handle file upload for applicable types
        if ($this->materialService->isFileUploadType($material->type) && $request->hasFile('file')) {
            $material->url = $this->materialService->update(
                $request->file('file'),
                $material->url,
                (string) $topic->id,
                $material->type
            );
        } elseif ($this->materialService->isLinkType($material->type)) {
            $material->url = $validated['url'];
        }

        $material->save();

        return $material;
    }

    /**
     * Reorder materials within a topic
     */
    public function reorder(Request $request, Topic $topic)
    {
        $validated = $request->validate([
            'materials' => 'required|array',
            'materials.*.id' => 'required|exists:materials,id',
            'materials.*.order' => 'required|integer'
        ]);

        foreach ($validated['materials'] as $materialData) {
            Material::where('id', $materialData['id'])
                ->where('topic_id', $topic->id)
                ->update(['order' => $materialData['order']]);
        }

        return response()->json(['message' => 'Materials reordered successfully']);
    }
}
