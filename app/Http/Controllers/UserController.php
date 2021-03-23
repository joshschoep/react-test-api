<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\User;
use DateTime;

abstract class UserActivityType {
    const Comment = 0;
    const Post = 1;
    const Undefined = 0;
}

class UserActivity {
    public $title = Null;
    public $content = "";
    public $created_at = Null;
    public $updated_at = Null;
    public $type = UserActivityType::Undefined;

    public function populate(Object $o, UserActivityType $type){
        $this->title = $o->title ?? "";
        $this->content = $o->content ?? "Unable to load content";
        $this->created_at = $o->created_at ?? new DateTime();
        $this->updated_at = $o->updated_at ?? Null;
        $this->type = $type;
    }
}

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
