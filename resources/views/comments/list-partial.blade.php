<article class="comments-list">
<h3>Comments</h3>
@foreach ($comments ?? [] as $comment)
    <article class="card my-3">
        <div class="card-body">
            <small class="card-title d-flex">
                <p class="mb-0">
                    <a href="/users/{{ $comment->owner_id }}">
                        {{ $comment->owner->name ?: $comment->owner_id ?: "Unknown" }}
                    </a>
                    at {{ $comment->created_at->format('M j, Y \a\t g:ia e') }}
                </p>
                    <div class="dropdown ml-auto">
                        <a class="nav-link dropdown-toggle p-0" type="button" id="post-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Options
                        </a>
                        <div class="dropdown-menu" aria-labelledby="post-dropdown">
                            <a class="dropdown-item text-primary" href="/comments/{{ $comment->id }}">View comment as page</a>
                            @if(Auth::id() == $comment->owner_id)
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-primary" href="/comments/{{ $comment->id }}/edit?redirect=/posts/{{ $post->id }}">Edit this comment</a>
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
@endforeach
</article>
@foreach ($comments ?: [] as $comment)
    @include('comments.delete-modal', ['comment' => $comment, 'redirect' => '/posts/' . $post->id])
@endforeach