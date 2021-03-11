@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
                <img src="/storage/{{$user->img}}" class="rounded-circle" width="150">
                @guest
                @else
                    @if (Auth::user()->name == $user->name)
                        <form action="{{route('user.image', ['user' => $user->id])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="file" name="img" class="form-control-file" accept="image/*">
                            </div>
                            <input class="btn btn-primary" type="submit" value="Change Avatar">
                        </form>
                    @endif
                @endguest
                <div class="mt-3">
                    <h>{{$user->name}}</h>
                    <p class="text-secondary mb-1">E-mail: {{$user->email}}</p>
                </div>
                <div class="row">
                    <ul class="list-group">
                        @foreach ($user->posts as $post)
                            <li class="list-group-item">
                                <a href="{{ route('posts.show', ['post' => $post]) }}">{{ $post->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
</div>
@endsection
