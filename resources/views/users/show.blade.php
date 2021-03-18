@extends('layouts.app')

@section('content')
<header>
    <h1>{{ $user->name }}</h1>
    <p class="lead text-muted">Joined on {{ $user->created_at->format('M d, Y') }}</p>
</header>
<main>
    <h2>Posts</h2>
    @include('blog-posts.list-partial', compact('posts'))
</main>
@stop