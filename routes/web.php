<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Auth::routes();

Route::get('posts/filter', 'PostController@search')->name('tags.search');
Route::get('posts/mostViews', 'PostController@mostViews')->name('posts.mostViews');
Route::get('posts/myPost', 'PostController@myPost')->name('posts.myPost');
Route::resource('posts', 'PostController');
/*Route::get('posts', 'PostController@index')->name('post.index');
Route::get('posts/create', 'PostController@create')->name('post.create');
Route::post('posts/store', 'PostController@store')->name('post.store');
Route::get('posts/show/{id}', 'PostController@show')->name('post.show');
Route::delete('posts/destroy/{id}', 'PostController@destroy')->name('post.destroy');
Route::get('posts/edit/{id}', 'PostController@edit')->name('post.edit');
Route::put('posts/update/{id}', 'PostController@update')->name('post.update');*/

Route::get('profile/{id}', 'UserController@show')->name('user.show');
Route::post('profile/{id}','UserController@image')->name('user.image');
