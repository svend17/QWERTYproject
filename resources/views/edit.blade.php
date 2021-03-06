@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Post</h1>
        <form method="post" enctype="multipart/form-data"
              action="{{ route('posts.update', ['post' => $post]) }}">
            @method('PUT')
            @include('form')
        </form>
    </div>
@endsection
