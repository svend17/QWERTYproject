<?php


namespace App\Repositories;


use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{
    protected $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function getById(int $id): Post
    {
        return $this->model->findOrFail($id);
    }

    public function save(array $input): Post
    {
        return $this->model->create($input);
    }

    public function update(int $id, array $input): bool
    {
        return $this->getById($id)->update($input);
    }

    public function delete(int $id)
    {
        $this->model->destroy($id);
    }

    public function getWithoutReplyPosts(): LengthAwarePaginator
    {
        return $this->model->doesntHave('comments')
            ->paginate(15);
    }

    public function getMostViewPosts(): LengthAwarePaginator
    {
        return $this->model->query()
            ->orderBy('views', 'desc')
            ->paginate(15);
    }

    public function getUserPosts(): LengthAwarePaginator
    {
        return $this->model->query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function index(): LengthAwarePaginator
    {
        return $this->model->query()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function filter($postsID): LengthAwarePaginator
    {
        return $this->model->whereIn('id', $postsID)->paginate(15);
    }
}
