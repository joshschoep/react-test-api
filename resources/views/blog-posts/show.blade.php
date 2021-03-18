@extends('layouts.app')

@section('content')
<header>
    <h1>{{ $post->title }}</h1>
    <div>
        <small>
            Posted by <a href="/users/{{ $owner->id }}">{{ $owner->name }}</a>
            on {{ $post->created_at->format('M j, Y \a\t g:ia') }}.
        </small>
    </div>
    @if($post->updated_at != $post->created_at)
        <div>
            <small class="text-muted">
                Last edited {{ $post->updated_at->diffForHumans() }}
                ({{ $post->updated_at->format('M j, Y \a\t g:ia') }})
            </small>
        </div>
    @endif
    @if(Auth::check() && Auth::id() == $post->owner_id)
        <div class="py-2">
            <a class="btn btn-primary" href="/posts/{{ $post->id }}/edit">Edit this post</a>
        </div>
    @endif
</header>

<div class="card px-2 py-1">
    <div class="card-content">
        <p class="card-text">{{ $post->content }}</p>
    </div>
</div>
@stop