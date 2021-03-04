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
                                Author: <a href="{{route('user.show', ['id' => $post->user->id])}}">{{ $post->author }}</a>
                                <br>
                                Дата: {{ date_format($post->created_at, 'd.m.Y H:i') }}
                            </div>
                        </span>
                        <a href="#" class="btn btn-dark float-right">Редактировать</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
