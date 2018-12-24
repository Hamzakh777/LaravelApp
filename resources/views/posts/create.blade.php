@extends('layouts.app')

@section('content')
    <div class="row ml-1">
        <h1>Create a new post</h1>
    </div>
    <div class="row">
        {!! Form::open(['url' => 'foo/bar']) !!}
            //
        {!! Form::close() !!}
    </div>
@endsection