@extends('layouts.app')

@section('content')
    <div class="row">
        <h1>Create a new post</h1>
    </div>
    <div class="row">
        {!! Form::open(["action" => "PostsController@store", "method" => "POST", "class" => "form", 'files' => true, 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group w-100">
                {{ Form::label( 'title', 'Title' ) }}
                {{ Form::text('title', '', ['class' => 'form-control w-100', 'placeholder' => 'Title']) }}
            </div>
            <div class="form-group">
                {{ Form::label( 'body', 'Body' ) }}
                {{ Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control w-100', 'placeholder' => 'Body Text']) }}
            </div>
            <div class="form-group">
                {{ Form::file('cover_image') }}
            </div>
            {{ Form::submit('Submit', ['class' => 'btn btn-secondary']) }}
        {!! Form::close() !!}
    </div>

    {{-- <div class="row">
    <form action="/posts/store" class="form" method="POST">
        @csrf
        <div class="form-group w-100">
            <label for="title">Title</label>
            <input type="text" name="title" placeholder="Enter the title" class='form-control'>
        </div>
        <div class="form-group w-100">
            <label for="body">Body</label>
            <textarea name="body" cols="30" rows="10" placeholder="Enter the body content here" class='form-control'></textarea>
        </div>
        <button type="submit" class='btn btn-secondary'>submitd</button>
    </form>
    </div> --}}
    
@endsection