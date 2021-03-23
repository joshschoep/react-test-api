@extends('layouts.app')

@section('head')
<link href="{{ asset('css/form.css') }}" rel="stylesheet">
@stop

@section('content')
<header>
    <h1>Edit comment</h1>
</header>
<form method="POST" action="/comments/{{ $comment->id }}?redirect={{ $request['redirect'] }}">
    @csrf()
    @method("PUT")
    <section class="form-group">
        <label for="content" hidden>Content</label>
        @error('content')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        <textarea name="content"
                class="form-control
                @error('content') border-danger @enderror
            "
            rows="5"
            placeholder="Write your comment here..."
        >{{ $request->old('content') ?: $comment->content ?: '' }}</textarea>
    </section>
    <section class="form-group">
        <button type="submit" class="btn btn-primary float-right">Update</button>
    </section>
</form>
@stop