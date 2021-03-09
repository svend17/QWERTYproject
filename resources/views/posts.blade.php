@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('post.index') }}">All Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('post.myPost') }}">My Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('post.mostViews') }}">Most Views</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#" >Without reply</a>
                </li>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col-6 mb-4">
                            <div class="card">
                                <div class="card-header">{{ $post->title }}</div>
                                <div class="card-body">{{ $post->excerpt }}</div>
                                <div class="card-footer">
                                    <div class="nav-link" >
                                        Author:
                                        @if($post->user)
                                            <a href="{{ route('user.show', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a>
                                        @else
                                            Anonim
                                        @endif
                                        <br>
                                        Date: {{ date_format($post->created_at, 'd.m.Y H:i') }}
                                        <br>
                                        Views: {{ $post->views }}
                                    </div>
                                </div>
                                <a href="{{ route('post.show', ['id' => $post->id]) }}" class="btn btn-dark float-right">Read...</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $posts->links() }}
            </ul>
        </div>
    </div>
</div>
@endsection
