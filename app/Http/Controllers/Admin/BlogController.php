<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();
        return view('Backend.Admin.Blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.Admin.Blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        $slug=Str::slug($request->title);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'blog/images';
            $file->move(public_path($destinationPath), $filename);
        }
        $blog = Blog::create($request->only('title', 'description', 'meta_description') + ['slug'=>$slug,'image' => $destinationPath . '/' . $filename, 'created_by' => auth()->user()->id]);
        if ($blog) {
            return redirect(route('admin.blog.index'))->with('success', 'Blog added successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $categories=Category::where("status", 1)->where("priority", "!=", "")->orderBy("priority", "asc")->get();
        $blog = Blog::where('slug',$slug)->first();
        return view('Frontend.Blog.details', compact('blog','categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('Backend.Admin.Blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        $slug=Str::slug($request->title);
        if ($request->hasFile('image')) {
            File::delete($blog->image);
            $file = $request->file('image');
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'blog/images';
            $file->move(public_path($destinationPath), $filename);
            $blog->update($request->only('title', 'description', 'meta_description') + ['slug'=>$slug,'image' => $destinationPath . '/' . $filename]);
        }else{
            $blog->update($request->only('title', 'description', 'meta_description')+['slug'=>$slug,]);
        }
        return redirect(route('admin.blog.index'))->with('success', 'Blog updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        File::delete($blog->image);
        $blog->delete();
        return back()->with('success', 'Blog deleted successfully');
    }
    public function status_change(Request $request)
    {
        Blog::where("id",$request->id)->update(["status"=>(($request->status == 1)?0:1)]);
        return back()->with('success', 'Payment method updated successfully!');
    }
}
