<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function getById(int $id): Post;
    public function index(): LengthAwarePaginator;
    public function save(array $input): Post;
    public function update(int $id, array $input): bool;
    public function filter($postsID): LengthAwarePaginator;
    public function delete(int $id): bool;

    public function getWithoutReplyPosts(): LengthAwarePaginator;
    public function getMostViewPosts(): LengthAwarePaginator;
    public function getUserPosts(): LengthAwarePaginator;
}
