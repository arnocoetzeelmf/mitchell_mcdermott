<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MyBlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showMyBlogs(Request $request)
    {
        $user = Auth::user();

        $my_blogs = Blog::select(['blog_title', 'blog_text', 'publication_datetime'])
            ->where('user_id', $user->id)
            ->orderBy('publication_datetime', ($request->has('order') ? $request->order : 'desc'))
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

    public function importExternalBlogs(Request $request){
        $admin_user = User::where('email', 'arno.coetzee.admin@gmail.com')->first();

        if($admin_user){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://candidate-test.sq1.io/api.php");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $output = curl_exec($ch);
            curl_close($ch);

            $output_array = json_decode($output);

            foreach($output_array->articles as $article){
                $blog = Blog::updateOrCreate(
                    [
                        'blog_title' => $article->title,
                        'blog_text' => $article->description,
                        'publication_datetime' => Carbon::parse($article->publishedAt)->toDateTimeString(),
                        'user_id' => $admin_user->id
                    ],
                    [
                    ]
                );
            }

            return response()->json('Articles imported', 201, [], \JSON_UNESCAPED_SLASHES);
        }

        return response()->json('Admin user not found', 404, [], \JSON_UNESCAPED_SLASHES);
    }

}
