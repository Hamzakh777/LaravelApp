@extends('layouts.app')

@section('content')
    @if (isset($post))
        <div class="row">
            <a href="/posts" class="btn btn-info text-light mb-3">Go Back</a>
        </div>
        <div class="row">
            <div class="card mb-3 w-100" >
                <div class="card-body">
                    <h1>{{ $post->title }}</h1>
                    <hr>
                    <p>{!! $post->body !!}</p>
                    <small>Written on {{$post->created_at}}</small>
                </div>
            </div>
            <a href="/posts/{{ $post->id }}/edit" class="btn btn-success">Edit</a>
            {!! Form::open(['action' => [ 'PostsController@destroy', $post->id ], 'method' => 'POST' , 'class' => 'float-right']) !!}
                {{ Form::hidden( '_method', 'DELETE') }}
                {{ Form::submit( 'Delete', ['class' => 'btn btn-danger']) }}
            {!! Form::close() !!}
        </div>
    @endif
    
@endsection