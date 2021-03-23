<article class="posts-list">
@foreach ($posts ?? [] as $post)
    <article class="card">
        <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>
            <small class="card-subtitle text-muted">
                Created by 
                <a href="/users/{{ $post->owner_id }}">
                    {{ $post->owner->name ?: $post->owner_id ?: "Unknown" }}
                </a>
                {{ $post->updated_at->diffForHumans() }}
            </small>
            <p class="card-text">{{ $post->lead }}</p>
            <a href="/posts/{{ $post->id }}" class="btn btn-primary">View</a>
        </div>
    </article>
@endforeach
<div class="pagination">
    @if (method_exists($posts, 'links'))
    {{ $posts->links() }}
    @endif
</div>

</article>