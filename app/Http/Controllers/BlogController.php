<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function showAllBlogs(Request $request)
    {
        $blogs = Blog::select(['blogs.blog_title', 'blogs.blog_text', 'blogs.publication_datetime', 'users.name'])
            ->join('users', 'blogs.user_id', 'users.id')
            ->orderBy('publication_datetime', ($request->has('order') ? $request->order : 'desc'))
            ->take(100)//limit the number of entries to 50 to prevent the return dataset from being too big - this can/will be improved with pagination
            ->get();

        return view('blog_view',['blogs' => $blogs]);
    }
}
