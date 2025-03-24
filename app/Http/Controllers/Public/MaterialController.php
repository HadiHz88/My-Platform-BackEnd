<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\JsonResponse;

/**
 * Class MaterialController
 *
 * This controller handles the retrieval of material data.
 * It provides a method to list all materials.
 */
class MaterialController extends Controller
{
    /**
     * Display a listing of the materials.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Material::all());
    }
}
