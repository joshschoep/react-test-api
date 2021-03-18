@extends('layouts.app')

@section('head')
<link href="{{ asset('css/form.css') }}" rel="stylesheet">
@stop

@section('content')
<header>
    <h1>Create a new post</h1>
</header>
<form method="POST" action="/posts" class="d-flex flex-column">
    @csrf()
    <section class="form-group">
        <label for="title">Post Title</label>
        <input type="text" 
            class="
                form-control 
                @error('title') border-danger @enderror
            " 
            name="title">
        @error('title')
            <p class="text-danger">{{ message }}</p>
        @enderror
    </section>
    <section class="form-group grow-section">
        <label for="content" hidden>Post Content</label>
        <textarea name="content"
            class="
                form-control
                @error('content') border-danger @enderror
            "
        ></textarea>
        @error('content')
            <p class="text-danger">{{ message }}</p>
        @enderror
    </section>
    <section class="form-group">
        <button type="submit" class="btn btn-primary float-right @error('any') disabled @enderror">Create Post</button>
    </section>
</form>
@stop