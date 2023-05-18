<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyBlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showMyBlogs()
    {
        $user = Auth::user();

        $my_blogs = Blog::select(['blog_title', 'blog_text', 'publication_datetime'])
            ->where('user_id', $user->id)
            ->get();

        return view('my_blog_view',['blogs' => $my_blogs]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'blog_title' => 'required',
            'blog_text' => 'required'
        ], [
            'blog_title.required' => 'Blog title is required.',
            'blog_text.required' => 'Blog details is required.'
        ]);

        $request->merge(['user_id' => $user->id]);

        $my_blog = Blog::create($request->all());

        return response()->json($my_blog, 201, [], \JSON_UNESCAPED_SLASHES);
    }
}
