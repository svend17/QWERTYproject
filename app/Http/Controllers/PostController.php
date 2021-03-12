<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private const MASSAGE_EDIT = 'Post Edit';
    private const MASSAGE_DELETE = 'Post Delete';
    private const MASSAGE_CREATE = 'Post Create';

    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * @var TagRepositoryInterface
     */
    private $tagRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * PostController constructor.
     * @param PostRepositoryInterface $postRepository
     * @param TagRepositoryInterface $tagRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        PostRepositoryInterface $postRepository,
        TagRepositoryInterface $tagRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the post.
     * @return View
     */
    public function index(): View
    {
        return view('posts', [
            'posts' => $this->postRepository->index(),
            'tags' => $this->tagRepository->getTags()
        ]);
    }

    /**
     * Display most views posts
     * @return View
     */
    public function mostViews(): View
    {
        return view('posts', [
            'posts' => $this->postRepository->getMostViewPosts(),
            'tags' => $this->tagRepository->getTags()
        ]);
    }

    /**
     * Display posts of the current user
     * @return View
     */
    public function myPost(): View
    {
        return view('posts', [
            'posts' => $this->postRepository->getUserPosts(),
            'tags' => $this->tagRepository->getTags()
        ]);
    }

    /**
     * @return View
     */
    public function withoutReply(): View
    {
        return view('posts', [
            'posts' => $this->postRepository->getWithoutReplyPosts(),
            'tags' => $this->tagRepository->getTags()
        ]);
    }

    /**
     * Show the form for creating a new post.
     * @return View
     */
    public function create(): View
    {
        return view('create', [
            'categories' => $this->categoryRepository->getCategories()
        ]);
    }

    /**
     * Store a newly created post.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->except('_token', 'tags');
        $input['user_id'] = Auth::id() ?? null;
        $post = $this->postRepository->save($input);
        $tagModels = $this->getTags(request('tags'));
        $post->tags()->attach($tagModels);

        return redirect()
            ->route('posts.index')
            ->with('success', self::MASSAGE_CREATE);
    }

    /**
     * Display the post.
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
     * @param  Post  $post
     * @return View
     */
    public function edit(Post $post): View
    {
        return view('edit', [
            'post'=>$post,
            'categories' => $this->categoryRepository->getCategories()
        ]);
    }

    /**
     * Update the post.
     * @param Request $request
     * @param  Post  $post
     * @return RedirectResponse
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $input = $request->except('_token', 'tags');
        $input['user_id'] = Auth::id() ?? null;
        $this->postRepository->update($post->id, $input);
        $tagModels = $this->getTags(request('tags'));
        $post->tags()->sync($tagModels);

        return redirect()
            ->route('posts.index')
            ->with('success', self::MASSAGE_EDIT);
    }

    /**
     * Remove the post.
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->postRepository->delete($post->id);

        return redirect()
            ->route('posts.index')
            ->with('success', self::MASSAGE_DELETE);
    }

    /**
     * Post Filtration by tags
     * @param Request $request
     * @return View
     */
    public function filter(Request $request): View
    {
        $postsId = $this->tagRepository->getPostIdByTags(request('tags'));

        return view('posts', [
            'posts' => $this->postRepository->filter($postsId),
            'tags' => $this->tagRepository->getTags()
        ]);
    }

    /**
     * Gets tag models from input string
     * @param $tagsInput
     * @return array
     */
    public function getTags(string $tagsInput): array
    {
        $tags = explode(",", $tagsInput);
        $tagModels = [];

        foreach ($tags as $tag)
        {
            $tagModels[] = $this->tagRepository->firstOrCreate($tag);
        }

        return $tagModels;
    }
}
