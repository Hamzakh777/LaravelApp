@extends('layouts.app')

@section('content')
    <div class="row">
        <h1>Create a new post</h1>
    </div>
    <div class="row">
        {!! Form::open(["action" => ["PostsController@update", $post->id ], "method" => "POST", "class" => "form", 'files' => true, 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group w-100">
                {{ Form::label( 'title', 'Title' ) }}
                {{ Form::text('title', $post->title , ['class' => 'form-control w-100', 'placeholder' => 'Title']) }}
            </div>
            <div class="form-group">
                {{ Form::label( 'body', 'Body' ) }}
                {{ Form::textarea('body', $post->body , ['id' => 'article-ckeditor', 'class' => 'form-control w-100', 'placeholder' => 'Body Text']) }}
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img src="/storage/cover_images/{{ $post->cover_image }}" alt="" style="height:60px">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        {{ Form::file('cover_image') }}
                    </div>
                </div>
                
            </div>
            {{ Form::hidden('_method', 'PUT') }}
            {{ Form::submit('Submit', ['class' => 'btn btn-secondary'])}}
        {!! Form::close() !!}
    </div>
@endsection