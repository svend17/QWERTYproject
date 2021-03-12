<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Auth::routes();

Route::get('posts/filter', 'PostController@filter')->name('tags.filter');
Route::get('posts/mostViews', 'PostController@mostViews')->name('posts.mostViews');
Route::get('posts/myPost', 'PostController@myPost')->name('posts.myPost');
Route::get('posts/withoutReply', 'PostController@withoutReply')->name('posts.withoutReply');
Route::post('comments/store', 'CommentController@store')->name('comments.store');

Route::resource('posts', 'PostController');

Route::get('users/{user}', 'UserController@show')->name('user.show');
Route::post('users/{user}','UserController@image')->name('user.image');
