@extends('layouts.app')

@section('content')
<header>
    <h1>{{ $user->name }}</h1>
    <p class="lead text-muted">Joined on {{ $user->created_at->format('M d, Y') }}</p>
</header>
<main>
    <h2>Activity</h2>
    @foreach($user->activity as $event)
    <div class="card my-3">
        <div class="card-body">
            @if($event->type == 'Post')
                <small class="text-muted card-subtitle text-uppercase">
                    Posted
                </small>
                <a href="/posts/{{ $event->id }}">
                    <h3 class="card-title">
                        {{ $event->title }}
                    </h3>
                </a>
            @elseif($event->type == 'Comment')
                <small class="text-muted card-subtitle text-uppercase">
                    Commented <a href="/posts/{{ $event->parent_id }}">on a post</a>
                </small>
            @endif
            <p class="card-text">
                {{ $event->content }}
            </p>
        </div>
    </div>
    @endforeach  
</main>
@stop