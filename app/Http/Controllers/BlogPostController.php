<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    protected static $POST_FIELD_VALIDATIONS = [
        'title' => ['required', 'max:255'],
        'content' => ['required'],
    ];


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
        $posts = BlogPost::orderByDesc('updated_at')->paginate(15);
        return view('blog-posts.index', compact('posts'));
    }

    public function show(Request $request, BlogPost $post)
    {
        return view('blog-posts.show', compact('request', 'post'));
    }

    public function create(Request $request)
    {
        return view('blog-posts.create', compact('request'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(BlogPostController::$POST_FIELD_VALIDATIONS);
        $validated['owner_id'] = Auth::id();
        $validated['lead'] = Str::limit($validated['content'], 200, $end='...');
        $new_post = BlogPost::create($validated);
        return redirect('/posts/' . $new_post->id);
    }

    public function edit(Request $request, BlogPost $post)
    {
        if(Auth::id() != $post->owner_id){
            return response()->view('no-permissions', [], 403);
        }
        return view('blog-posts.edit', compact('post', 'request'));
    }

    public function update(Request $request, BlogPost $post)
    {
        if(Auth::id() != $post->owner_id){
            return response()->view('no-permissions', [], 403);
        }
        $validated = $request->validate(BlogPostController::$POST_FIELD_VALIDATIONS);
        $validated['lead'] = Str::limit($validated['content'], 200, $end='...');
        $post->update($validated);
        return redirect('/posts/' . $post->id);
    }

    public function destroy(BlogPost $post){
        if(Auth::id() != $post->owner_id){
            return response()->view('no-permissions', [], 403);
        }
        $post->delete();
        return redirect('/recent');
    }
}
