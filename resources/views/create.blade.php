@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="mt-2 mb-3">Create post</h1>
                <form method="post" action="{{ route('post.store') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="Tittle" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="excerpt" placeholder="Excerpt" required></textarea>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="body" placeholder="Text" rows="7" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
