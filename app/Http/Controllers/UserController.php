<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($user)
    {
        $user = User::find($user);
        $posts = BlogPost::where('owner_id', $user->id)->orderByDesc('updated_at')->get();
        return view('users.show', ['user' => $user, 'posts' => $posts]);
    }
}
