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
        $posts = Post::select('posts.*')
            ->orderBy('posts.created_at', 'desc')
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
        $posts = Post::select('posts.*')
            ->orderBy('views', 'desc')
            ->paginate(15);
        return view('posts',
            ['posts' => $posts, 'tags' => Tag::all()]
        );
    }

    /**
     * Display posts of the current user
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function myPost()
    {
        $posts = Post::select('posts.*')
            ->where('user_id', Auth::id())
            ->orderBy('posts.created_at', 'desc')
            ->paginate(15);
        return view('posts',
            ['posts' => $posts, 'tags' => Tag::all()]
        );
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
        $post = new Post;
        $post->title = $request->title;
        $post->excerpt = $request->excerpt;
        $post->body = $request->body;
        if (Auth::check()) {
            $post->user_id = Auth::id();
        }
        $tags = explode(",", $request->tags);
        $tagModels = [];
        foreach ($tags as $tag)
        {
            $tagModels[] = Tag::firstOrCreate([
                'name' => $tag
            ])->id;
        }
        $post->category_id = $request->category;
        $post->save();
        $post->tags()->attach($tagModels);
        return redirect()
            ->route('posts.index')
            ->with('success', 'Post added');
    }

    /**
     * Display the post.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(int $id)
    {
        $post = Post::findOrFail($id);
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
    public function edit(int $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('edit', ['post'=>$post, 'categories' => $categories]);
    }

    /**
     * Update the post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->excerpt = $request->excerpt;
        $post->body = $request->body;
        $post->category_id = $request->category;
        $post->created_at = date('Y-m-d H:i:s');
        $post->save();
        $tags = explode(",", $request->tags);
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
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
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
        $posts = Post::whereIn('id', $postsId)->get();
        return view('posts', ['posts' => $posts, 'tags' => Tag::all()]);
    }
}
