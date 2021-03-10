@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Post</h1>
        <form method="post" enctype="multipart/form-data" action="{{ route('posts.store') }}">
            @include('form')
        </form>
    </div>
@endsection
