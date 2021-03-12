<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface TagRepositoryInterface
{
    public function getTags(): Collection;
    public function getPostIdByTags(array $tags);
    public function firstOrCreate(string $tag);
}
