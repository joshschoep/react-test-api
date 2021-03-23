@extends('layouts.app')

@section('content')
<header>
    <h1>
        <a href="/users/{{ $comment->owner_id }}">
            {{ $comment->owner->name ?: $comment->owner_id ?: "Unknown" }}
        </a>
        at {{ $comment->created_at->format('M j, Y \a\t g:ia e') }}
    </h1>
    <p class="lead text-muted">from <a href="/posts/{{ $comment->post->id }}">{{ $comment->post->title }}</a></p>
</header>
<article class="card my-3">
    <div class="card-body">
        <small class="card-title d-flex">
            <p>
                <a href="/users/{{ $comment->owner_id }}">
                {{ $comment->owner->name ?: $comment->owner_id ?: "Unknown" }}
                </a>
                at {{ $comment->created_at->format('M j, Y \a\t g:ia e') }}
            </p>
                <div class="dropdown ml-auto">
                    <a class="nav-link dropdown-toggle" type="button" id="post-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Options
                    </a>
                    <div class="dropdown-menu" aria-labelledby="post-dropdown">
                        <a class="dropdown-item text-primary" href="" data-toggle="modal" data-target="#display-link-modal">Get link</a>
                        @if(Auth::id() == $comment->owner_id)
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-primary" href="/comments/{{ $comment->id }}/edit?redirect=/comments/{{ $comment->id }}">Edit this comment</a>
                            <a class="dropdown-item text-danger" href="" data-toggle="modal" data-target="#delete-comment-modal-{{ $comment->id }}">Delete this comment</a>
                        @endif
                    </div>
                </div>
        </small>
        <p class="card-text">
            @if($comment->updated_at && $comment->updated_at != $comment->created_at)
                <small class="text-muted">(edited)</small>
            @endif
            {{ $comment->content }}
        </p>
    </div>
</article>
<div class="modal fade" id="display-link-modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Shareable Link</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input class="form-control" readonly value="{{ $request->url() }}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@include('comments.delete-modal', ['comment' => $comment, 'redirect' => '/'])
@stop