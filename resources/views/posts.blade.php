@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <ul>
                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col-6 mb-4">
                            <div class="card">
                                <div class="card-header">{{ $post->title }}</div>
                                <div class="card-body">{{ $post->excerpt }}</div>
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
