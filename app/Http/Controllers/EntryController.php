<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EntryController extends Controller
{
    public function index(){
        $educations = Entry::where('type', 'education')->get()->all();
        $works = Entry::where('type', 'work')->get()->all();
        $projects = Entry::where('type', 'project')->get()->all();

        //
    }

    public function create(){
        // return
    }

    public function store(Request $request){
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $entry = Entry::create($validated);

        // return
    }

    public function show(Entry $entry){
        // return
    }

    public function edit(Entry $entry){
        // return
    }

    public function update(Request $request, Entry $entry){
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $entry->update($validated);

        // return
    }

    public function destroy(Entry $entry){
        $entry->delete();

        // return
    }
}
