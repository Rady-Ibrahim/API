<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class blogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::where('user_id',request()->user()->id)->paginate(2);
        //dd(Blog::all());
        return view('blog.index',compact('blogs'));  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:3|max:20',
            'description' => 'required|min:3|max:1000',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $data['banner_image'] = $request->file('banner_image')->store('blog','public');
        $data["user_id"] = request()->user()->id;
        
        Blog::create($data);
        //dd($data);
        return redirect('blog')->with('success','Blog Created Successfully!');
        //return redirect('blog');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('blog.show',compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('blog.edit',compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title' => 'required|min:3|max:20',
            'description' => 'required|min:3|max:1000',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('banner_image')) {
            if ($blog->banner_image) {
                Storage::disk('public')->delete($blog->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('blog','public');
        }   
        //$data['banner_image'] = $request->file('banner_image')->store('blog','public');
        $blog->update($data);
        
        return redirect('blog')->with('success','Blog Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->banner_image) {
            Storage::disk('public')->delete($blog->banner_image);
        }
        $blog->delete();
        return redirect('blog')->with('success','Blog Deleted Successfully!');
    }

}
//
