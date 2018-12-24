@extends('layouts.app')

@section('content')
    @if (isset($post))
        <h1>{{ $post->title }}</h1>
    @endif
@endsection