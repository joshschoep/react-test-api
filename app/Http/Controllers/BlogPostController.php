<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    protected static $POST_FIELD_VALIDATIONS = [
        'title' => ['required', 'max:255'],
        'content' => ['required'],
    ];

    public function index()
    {
        $posts = BlogPost::orderByDesc('created_at')->paginate(15);
        return json_encode($posts);
    }

    public function show(int $id)
    {
        return json_encode(BlogPost::with('comments')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(BlogPostController::$POST_FIELD_VALIDATIONS);
        $validated['owner_id'] = Auth::id();
        $validated['lead'] = Str::limit($validated['content'], 200, $end='...');
        $new_post = BlogPost::create($validated);
        return response()->json_encode($new_post, 200);
    }

    public function update(Request $request, BlogPost $post)
    {
        if(!Gate::allows('modify-content', $post)) {
            return response()->json(null, 403);
        }
        $validated = $request->validate(BlogPostController::$POST_FIELD_VALIDATIONS);
        $validated['lead'] = Str::limit($validated['content'], 200, $end='...');
        $post->update($validated);
        return response()->json_encode($post, 200);
    }

    public function destroy(BlogPost $post){
        if(!Gate::allows('modify-content', $post)) {
            return response()->json(null, 403);
        }
        $post->delete();
        return response()->json(null, 200);
    }
}
