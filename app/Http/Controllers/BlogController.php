<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function showAllBlogs()
    {
        $blogs = Blog::select(['blogs.blog_title', 'blogs.blog_text', 'blogs.publication_datetime', 'users.name'])
            ->join('users', 'blogs.user_id', 'users.id')
            ->get();

        return view('blog_view',['blogs' => $blogs]);
    }
}
