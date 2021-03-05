@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4 mb-4">
                <div class="card-header">
                    <h1>{{ $post->title }}</h1>
                </div>
                <div class="card-body">
                    <p class="mt-3 mb-0">{{ $post->body }}</p>
                </div>
                <div class="card-footer">
                    <div class="clearfix">
                        <span class="float-left">
                            <div class="nav-link" >
                                Author: <a href="{{route('user.show', ['id' => $post->user->id])}}">{{ $post->user->name }}</a>
                                <br>
                                Дата: {{ date_format($post->created_at, 'd.m.Y H:i') }}
                            </div>
                        </span>
                        @if (Auth::user()->name == $post->user->name)
                            <div class="nav-link" >
                                <form method="post" action="{{ route('post.destroy', ['id' => $post->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary">Delete</button>
                                </form>
                                <form method="get" action="{{ route('post.edit', ['id' => $post->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
