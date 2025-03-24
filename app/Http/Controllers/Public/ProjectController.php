<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;

/**
 * Class ProjectController
 *
 * This controller handles the retrieval of project data.
 * It provides methods to list all projects and to show a specific project with its associated tags.
 */
class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        return response()->json(Project::with('tags')->get());
    }

    /**
     * Display the specified project.
     *
     * @param Project $project The project instance to display.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Project $project){
        return response()->json($project->load('tags'));
    }

}
