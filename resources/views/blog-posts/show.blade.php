@extends('layouts.app')

@section('head')
<script src="{{ asset('js/modal.js') }}"></script>
@stop

@section('content')
<header>
    <h1>{{ $post->title }}</h1>
    <div>
        <small>
            Posted by <a href="/users/{{ $post->owner_id }}">{{ $post->owner->name }}</a>
            on {{ $post->created_at->format('M j, Y \a\t g:ia e' ) }}.
        </small>
    </div>
    @if($post->updated_at != $post->created_at)
        <div>
            <small class="text-muted">
                Last edited {{ $post->updated_at->diffForHumans() }}
                ({{ $post->updated_at->format('M j, Y \a\t g:ia e') }})
            </small>
        </div>
    @endif
    @if(Auth::check() && Auth::id() == $post->owner_id)
        <div class="dropdown pt-3 pb-2">
            <button class="btn btn-primary dropdown-toggle" type="button" id="post-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                This is your post
            </button>
            <div class="dropdown-menu" aria-labelledby="post-dropdown">
                <a class="dropdown-item text-primary" href="/posts/{{ $post->id }}/edit">Edit this post</a>
                <a type="button" data-toggle="modal" data-target="#delete-post-modal" class="dropdown-item text-danger" href="#">Delete this post</a>
            </div>
        </div>
    @endif
</header>

@include('blog-posts.delete-modal', compact('post'))

<div class="card px-2 py-1">
    <div class="card-content">
        <p class="card-text post-content">{{ $post->content }}</p>
    </div>
</div>
<div class="my-5">
    <form method="POST" action="/posts/{{ $post->id }}/comments" class="pt-2 pb-4">
        @csrf()
        <section class="form-group">
            <label for="content">Comment on this post</label>
            <textarea class="form-control" name="content" rows="5" placeholder="Write your comment here...">{{ $request->old('content') }}</textarea>
            @error('content')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </section>
        <button class="btn btn-primary" type="submit" id="submitForm">Submit</button>
    </form>
    @include('comments.list-partial', ['comments' => $post->comments])
</div>
@stop