@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <ul>
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
                                <div class="card-footer"><div class="nav-link" >
                                        Author: <a href="{{route('user.show', ['id' => $post->user->id])}}">{{ $post->author }}</a>
                                        <br>
                                        Date: {{ date_format($post->created_at, 'd.m.Y H:i') }}
                                        <br>
                                        Views: {{ $post->views }}
                                    </div></div>
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
