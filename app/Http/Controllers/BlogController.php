<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        $blogs = Blog::all();

        return json_encode($blogs);
    }

    public function show($id){
        $blog = Blog::find($id);

        return json_encode($blog);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required'
        ]);

        Blog::create($validated);

        return json_encode('success');
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required'
        ]);

        Blog::find($id)->update($validated);

        return json_encode('success');
    }

    public function destroy($id){
        Blog::find($id)->delete();

        return json_encode('success');
    }
}
