@extends('layouts.app')

@section('content')
<header>
    <h1>Showing recent posts</h1>
</header>
@include('blog-posts.list-partial', compact('posts'))
@stop
