<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BlogPostController extends Controller
{
    public function root()
    {
        if(Auth::check()){
            return redirect('recent');
        }else{
            return view('welcome');
        }
    }

    public function index()
    {
        $posts = BlogPost::orderByDesc('updated_at')->paginate(20);
        foreach($posts as $post){
            $post->owner_name = User::where('id', $post->owner_id)
                ->first()
                ->name;
        }
        return view('blog-posts.index', compact('posts'));
    }

    public function show(BlogPost $post)
    {
        $owner = User::find($post->owner_id);
        return view('blog-posts.show', compact('post', 'owner'));
    }

    public function create()
    {
        return view('blog-posts.create');
    }

    public function store(BlogPost $post)
    {
        return 'store works!';
    }

    public function edit(BlogPost $post)
    {
        if(Auth::id() != $post->owner_id){
            return view('blog-posts.edit', compact('post'));
        }else{
            return "woohoo";
        }
    }

    public function update(BlogPost $post)
    {
        return 'update works';
    }
}
