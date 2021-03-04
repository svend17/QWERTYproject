<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/posts', 'PostController@index')->name('post.index');
Route::get('/post/show/{id}', 'PostController@show')->name('post.show');
