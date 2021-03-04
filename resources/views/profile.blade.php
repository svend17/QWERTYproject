@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" class="rounded-circle" width="150">
                <button class="btn btn-primary">Change Avatar</button>
                <div class="mt-3">
                    <h>{{$user->name}}</h>
                    <p class="text-secondary mb-1">E-mail: {{$user->email}}</p>
                </div>
                <div class="row">
                    @foreach($user->post as $post)
                        <a href="{{ route('post.show', ['id' => $post->id]) }}" class="card-header">{{ $post->title }}</a>
                    @endforeach
                </div>
            </div>
        </div>
</div>
@endsection
