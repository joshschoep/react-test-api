@extends('layouts.app')

@section('head')
<link href="{{ asset('css/form.css') }}" rel="stylesheet">
@stop

@section('content')
<header>
    <h1>Edit post</h1>
</header>
<form method="POST" action="/posts/{{ $post->id }}" class="d-flex flex-column">
    @csrf()
    @method('PUT')
    <section class="form-group">
        <label for="title">Post Title</label>
        <input type="text" 
            class="
                form-control
                @error('title') border-danger @enderror
            "
            name="title"
            value="{{ $request->old('title') ?: $post->title ?: '' }}">
        @error('title')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </section>
    <section class="form-group grow-section">
        <label for="content" hidden>Post Content</label>
        @error('content')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        <textarea name="content"
            class="
                form-control
                @error('content') border-danger @enderror
            "
            placeholder="Write your post here..."
        >{{ $request->old('content') ?: $post->content ?: '' }}</textarea>
    </section>
    <section class="form-group">
        <button type="submit" class="btn btn-primary float-right @error('any') disabled @enderror">Update</button>
    </section>
</form>
@stop