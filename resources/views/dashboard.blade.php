@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/posts/create" class="btn btn-secondary">Create Post</a>
                    <table class="table mt-3">
                        <thead>
                            <tr>
                              <th scope="col">Title</th>
                              <th scope="col"></th>
                              <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @if (count($posts) > 0)
                                    @foreach ($posts->reverse() as $post)
                                        <tr>
                                            <td>{{ $post->title }}</td>
                                            <td><a href="/posts/{{ $post->id }}/edit" class="btn btn-success">Edit</a></td>
                                            <td>{!! Form::open(['action' => [ 'PostsController@destroy', $post->id ], 'method' => 'POST' , 'class' => 'float-right']) !!}
                                                    {{ Form::hidden( '_method', 'DELETE') }}
                                                    {{ Form::submit( 'Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
