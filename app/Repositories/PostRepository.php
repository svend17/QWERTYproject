<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{
    private const POST_PER_PAGE = 15;

    /**
     * @var Post
     */
    protected $model;

    /**
     * PostRepository constructor.
     * @param Post $model
     */
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    /**
     * Get Post model by id
     * @param int $id
     * @return Post
     */
    public function getById(int $id): Post
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create Post
     * @param array $input
     * @return Post
     */
    public function save(array $input): Post
    {
        return $this->model->create($input);
    }

    /**
     * Update Post
     * @param int $id
     * @param array $input
     * @return bool
     */
    public function update(int $id, array $input): bool
    {
        return $this->getById($id)->update($input);
    }

    /**
     * Delete Post
     * @param int $id
     */
    public function delete(int $id): bool
    {
        return $this->model->destroy($id);
    }

    /**
     * Get Posts without comments
     * @return LengthAwarePaginator
     */
    public function getWithoutReplyPosts(): LengthAwarePaginator
    {
        return $this->model
            ->doesntHave('comments')
            ->paginate(static::POST_PER_PAGE);
    }

    /**
     * Get most viewed posts
     * @return LengthAwarePaginator
     */
    public function getMostViewPosts(): LengthAwarePaginator
    {
        return $this->model
            ->orderBy('views', 'desc')
            ->paginate(15);
    }

    /**
     * Get Posts of the current user
     * @return LengthAwarePaginator
     */
    public function getUserPosts(): LengthAwarePaginator
    {
        return $this->model
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    /**
     * Get all Posts
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return $this->model->query()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    /**
     * Get Posts by filter of tags
     * @param $postsID
     * @return LengthAwarePaginator
     */
    public function filter($postsID): LengthAwarePaginator
    {
        return $this->model->whereIn('id', $postsID)->paginate(15);
    }
}
