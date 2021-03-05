<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('post.index');
});

Auth::routes();

Route::get('post/index', 'PostController@index')->name('post.index');
Route::get('post/index/mostViews', 'PostController@mostViews')->name('post.mostViews');
Route::get('post/index/myPost', 'PostController@myPost')->name('post.myPost');
Route::get('post/create', 'PostController@create')->name('post.create');
Route::post('post/store', 'PostController@store')->name('post.store');
Route::get('post/show/{id}', 'PostController@show')->name('post.show');
Route::delete('post/destroy/{id}', 'PostController@destroy')->name('post.destroy');
Route::get('post/edit/{id}', 'PostController@edit')->name('post.edit');
Route::put('post/update/{id}', 'PostController@update')->name('post.update');

Route::get('profile/{id}', 'UserController@show')->name('user.show');
Route::post('profile/{id}','UserController@image')->name('user.image');
