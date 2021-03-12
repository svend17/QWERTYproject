<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\TagsPosts;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TagRepository implements TagRepositoryInterface
{
    /**
     * @var TagsPosts
     */
    protected $tagsPosts;
    /**
     * @var Tag
     */
    protected $tag;

    /**
     * TagRepository constructor.
     * @param TagsPosts $tagsPosts
     * @param Tag $tag
     */
    public function __construct(TagsPosts $tagsPosts, Tag $tag)
    {
        $this->tagsPosts = $tagsPosts;
        $this->tag = $tag;
    }

    /**
     * Get collection of Tags
     * @return Collection
     */
    public function getTags(): Collection
    {
        return Tag::all();
    }

    /**
     * Get id of post which have selected tags
     * @param array $tags
     * @return mixed
     */
    public function getPostIdByTags(array $tags)
    {
        return $this->tagsPosts->select('post_id')
            ->whereIn('tag_id', $tags)
            ->distinct()
            ->get();
    }

    /**
     * Create distinct tags
     * @param string $tag
     * @return mixed
     */
    public function firstOrCreate(string $tag)
    {
        return $this->tag->firstOrCreate(['name' => $tag])->getKey();
    }
}
