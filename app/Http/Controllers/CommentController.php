<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPost $post, Request $request)
    {
        $validated = $request->validate([
            'content' => 'required'
        ]);

        $validated['owner_id'] = Auth::id();
        $validated['post_id'] = $post->id;
        $new_comment = Comment::create($validated);
        return response()->json_encode($new_comment, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return response()->json(null, 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Comment $comment)
    {
        if(!Gate::allows('modify-content', $comment)){
            return response()->json(null, 403);
        }
        $validated = $request->validate(['content' => 'required']);
        $comment->update($validated);
        return response()->json($comment, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Comment $comment)
    {
        if(!Gate::allows('modify-content', $post)){
            return response()->json(null, 403);
        }
        $comment->delete();
        return response()->json(null, 200);
    }
}
