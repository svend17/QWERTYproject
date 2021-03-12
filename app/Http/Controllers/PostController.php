<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\TagsPosts;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $postRepository;

    /**
     * PostController constructor.
     *
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the post.
     *
     * @return View
     */
    public function index(): View
    {
        return view('posts', ['posts' => $this->postRepository->index(), 'tags' => Tag::all()]);
    }

    /**
     * Display most views posts
     *
     * @return View
     */
    public function mostViews(): View
    {
        return view('posts', [
            'posts' => $this->postRepository->getMostViewPosts(),
            'tags' => Tag::all()
        ]);
    }

    /**
     * Display posts of the current user
     *
     * @return View
     */
    public function myPost(): View
    {
        return view('posts', [
            'posts' => $this->postRepository->getUserPosts(),
            'tags' => Tag::all()
        ]);
    }

    public function withoutReply()
    {
        return view('posts', [
            'posts' => $this->postRepository->getWithoutReplyPosts(),
            'tags' => Tag::all()
        ]);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return View
     */
    public function create(): View
    {
        return view('create', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created post.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $input = [
            'title' => request('title'),
            'excerpt' => request('excerpt'),
            'body' => request('body'),
            'user_id' => Auth::id() ?? null,
            'category_id' => request('category')
        ];

        $post = $this->postRepository->save($input);
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
     * @return View
     */
    public function show(Post $post): View
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
     * @param  Post  $post
     * @return View
     */
    public function edit(Post $post): View
    {
        return view('edit', ['post'=>$post, 'categories' => Category::all()]);
    }

    /**
     * Update the post.
     *
     * @param Request $request
     * @param  Post  $post
     * @return RedirectResponse
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $input = ([
            'title' => request('title'),
            'excerpt' => request('excerpt'),
            'body' => request('body'),
            'user_id' => Auth::id() ?? null,
            'category_id' => request('category')
        ]);

        $this->postRepository->update($post->id, $input);
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
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->postRepository->delete($post->id);
        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted');
    }

    /**
     * Post Filtration by tags
     *
     * @param Request $request
     * @return View
     */
    public function filter(Request $request): View
    {
        $postsId = TagsPosts::select('post_id')->whereIn('tag_id', $request->tags)->distinct()->get();
        $posts = Post::whereIn('id', $postsId)->paginate(15);
        return view('posts', ['posts' => $posts, 'tags' => Tag::all()]);
    }
}
