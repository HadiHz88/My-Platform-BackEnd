<?php

namespace App\Http\Controllers\Public;
use App\Models\Course;
use App\Models\Entry;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

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

        // logos
        $logo_white_on_black= asset('storage/logos/logo_white_on_black.png');
        $logo_black_on_white= asset('storage/logos/logo_white_on_black.png');
        $logo_blue_on_black = asset('storage/logos/logo_blue_on_black.png');

        // Profile info
        $profileInfo = [
            'name' => 'John Doe',
            'title' => 'Full Stack Developer',
            'bio' => '',
            'github' => '',
            'linkedin' => '',
            'email' => '',
            'resumeUrl' => '',
            'profileImage' => url(asset('storage/logos/profile_image.jpg'))
        ];


        return response()->json([
            'skills' => $skills,
            'educations' => $educations,
            'experiences' => $experiences,
            'latestProjects' => $latestProjects,
            'latestCourses' => $latestCourses,
            'logo_white_on_black' => url($logo_white_on_black),
            'logo_black_on_white' => url($logo_black_on_white),
            'logo_blue_on_black' => url($logo_blue_on_black),
            'profileInfo' => $profileInfo,
        ]);
    }
}
