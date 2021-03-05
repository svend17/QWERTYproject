<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::select('posts.*', 'users.name as author')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->orderBy('posts.created_at', 'desc')
            ->paginate(15);
        return view('posts', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create() {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->excerpt = $request->excerpt;
        $post->body = $request->body;
        $post->user_id = Auth::id();
        $post->save();
        return redirect()
            ->route('post.index')
            ->with('success', 'Post added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(int $id)
    {
        $post = Post::find($id);
        return view('showPost', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()
            ->route('post.index')
            ->with('success', 'Post deleted');
    }
}
