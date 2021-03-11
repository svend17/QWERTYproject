<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\TagsPosts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the post.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $posts = Post::query()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('posts', ['posts' => $posts, 'tags' => Tag::all()]);
    }

    /**
     * Display most views posts
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function mostViews()
    {
        $posts = Post::query()
            ->orderBy('views', 'desc')
            ->paginate(15);
        return view('posts', ['posts' => $posts, 'tags' => Tag::all()]
        );
    }

    /**
     * Display posts of the current user
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function myPost()
    {
        $posts = Post::query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('posts', ['posts' => $posts, 'tags' => Tag::all()]);
    }

    public function withoutReply()
    {
        $posts = Post::doesntHave('comments')->paginate(15);
        return view('posts', ['posts' => $posts, 'tags' => Tag::all()]);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = Category::all();
        return view('create', ['categories' => $categories]);
    }

    /**
     * Store a newly created post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $post = Post::create([
            'title' => request('title'),
            'excerpt' => request('excerpt'),
            'body' => request('body'),
            'user_id' => Auth::id() ?? null,
            'category_id' => request('category')
        ]);

        $tags = explode(",", request('tags'));
        $tagModels = [];

        foreach ($tags as $tag)
        {
            $tagModels[] = Tag::firstOrCreate([
                'name' => $tag
            ])->id;
        }

        $post->tags()->attach($tagModels);
        return redirect()
            ->route('posts.index')
            ->with('success', 'Post added');
    }

    /**
     * Display the post.
     *
     * @param  Post $post
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Post $post)
    {
        $post->views++;
        $post->save();
        return view('showPost',
            ['post' => $post]
        );
    }

    /**
     * Show the form for editing post.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('edit', ['post'=>$post, 'categories' => $categories]);
    }

    /**
     * Update the post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Post $post)
    {
        Post::update([
            'title' => request('title'),
            'excerpt' => request('excerpt'),
            'body' => request('body'),
            'user_id' => Auth::id() ?? null,
            'category_id' => request('category')
        ]);

        $tags = explode(",", request('tags'));
        $tagModels = [];

        foreach ($tags as $tag)
        {
            $tagModels[] = Tag::firstOrCreate([
                'name' => $tag
            ])->id;
        }

        $post->tags()->sync($tagModels);
        return redirect()
            ->route('posts.index')
            ->with('success', 'Post edited');
    }

    /**
     * Remove the post.
     *
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
        } catch (Exception $e) {
            abort('404');
        }
        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted');
    }

    /**
     * Post Filtration
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request)
    {
        $postsId = TagsPosts::select('post_id')->whereIn('tag_id', $request->tags)->distinct()->get();
        $posts = Post::whereIn('id', $postsId)->paginate(15);
        return view('posts', ['posts' => $posts, 'tags' => Tag::all()]);
    }
}
