<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\User;
use DateTime;

class UserController extends Controller
{
    public function show($user)
    {
        $user = User::find($user);
        $user->activity = $this->getActivity($user);
        return view('users.show', compact('user'));
    }

    protected function getActivity(User $user){
        $posts = $user->posts()->select('Post as type', ' as parent_id', 'id', 'title', 'lead as content', 'created_at', 'updated_at');
        $comments = $user->comments()->select('Comment as type', ' as title', 'post_id as parent_id', 'id', 'content', 'created_at', 'updated_at');
            
        $activity = $posts->union($comments)->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->get();
        return $activity;
    }
}
