<?php


namespace App\Repositories\Interfaces;



interface PostRepositoryInterface
{
    public function getById(int $id);
    public function index();
    public function save(array $input);
    public function update(int $id, array $input);
    public function filter($postsID);
    public function delete(int $id);

    public function getWithoutReplyPosts();
    public function getMostViewPosts();
    public function getUserPosts();
}
