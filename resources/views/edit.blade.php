@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Post</h1>
        <form method="post" enctype="multipart/form-data"
              action="{{ route('post.update', ['id' => $post->id]) }}">
            @method('PUT')
            @include('form')
        </form>
    </div>
@endsection
