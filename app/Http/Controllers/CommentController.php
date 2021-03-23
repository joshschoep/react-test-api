<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
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
        Comment::create($validated);

        return redirect('/posts/' . $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Comment $comment)
    {
        return view('comments.show', compact('request', 'comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Comment $comment)
    {
        return view('comments.edit', compact('request', 'comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        if(!Gate::allows('modify-content', $comment)){
            return response()->view('no-permissions', [], 403);
        }
        $validated = $request->validate(['content' => 'required']);
        $comment->update($validated);
        return redirect($request['redirect'] ?: '/comments/' . $comment->id);
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
            return response()->view('no-permissions', [], 403);
        }
        $comment->delete();
        return redirect($request['redirect'] ?: '/');
    }
}
