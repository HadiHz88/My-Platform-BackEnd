<?php

namespace App\Http\Controllers\Public;
use App\Models\Course;
use App\Models\Entry;
use App\Models\Project;
use App\Models\Tag;

class HomeController extends \App\Http\Controllers\Controller
{
    public function index(){
        // get the skills
        $skills = Tag::skills()->get();

        // get the entries
        $educations = Entry::where('type', 'education')->get();
        $experiences = Entry::where('type', 'experience')->get();

        // get the latest projects
        $latestProjects = Project::with('tags')->latest()->take(3)->get();

        // latest course updated
        $latestCourses = Course::with(['tags'])->take(3)->get();

        return response()->json([
            'skills' => $skills,
            'educations' => $educations,
            'experiences' => $experiences,
            'latestProjects' => $latestProjects,
            'latestCourses' => $latestCourses
        ]);
    }
}
