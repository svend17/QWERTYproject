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
                                Author:
                                @if($post->user)
                                    <a href="{{ route('user.show', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a>
                                @else
                                    Anonim
                                @endif
                                <br>
                                Дата: {{ date_format($post->created_at, 'd.m.Y H:i') }}
                                <br>
                                Category: {{ $post->category->name }}
                            </div>
                        </span>
                        @if (Auth::check() && Auth::user()->id === $post->user_id)
                            <div class="nav-link" >
                                <form method="post" action="{{ route('posts.destroy', ['post' => $post]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary">Delete</button>
                                </form>
                                <form method="get" action="{{ route('posts.edit', ['post' => $post]) }}">
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
