@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="get" action="{{ route('tags.search', ['tags' => $tags]) }}">
                <div class="row d-flex justify-content-center mt-100">
                    <div class="col-md-6">
                        <select id="choices-multiple-remove-button" placeholder="Select tags" multiple name="tags[]">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" name="tag">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </form>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('posts.index') }}">All Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('posts.myPost') }}">My Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('posts.mostViews') }}">Most Views</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('posts.withoutReply') }}" >Without reply</a>
                </li>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @foreach ($posts as $post)
                        <div class="col-6 mb-4">
                            <div class="card">
                                <div class="card-header">{{ $post->title }}</div>
                                <div class="card-body">{{ $post->excerpt }}</div>
                                <div class="card-footer">
                                    <div class="nav-link" >
                                        Author:
                                        @if($post->user)
                                            <a href="{{ route('user.show', ['user' => $post->user->id]) }}">{{ $post->user->name }}</a>
                                        @else
                                            Anonim
                                        @endif
                                        <br>
                                        Date: {{ date_format($post->created_at, 'd.m.Y H:i') }}
                                        <br>
                                        Views: {{ $post->views }}
                                        <br>
                                        Tags:
                                        @foreach($post->tags as $tag)
                                            {{ $tag->name }}
                                        @endforeach
                                    </div>
                                </div>
                                <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="btn btn-dark float-right">Read...</a>
                            </div>
                        </div>
                    @endforeach
                </div>

        {{ $posts->appends(request()->query())->links() }}
            </ul>
        </div>
    </div>
</div>
@endsection
