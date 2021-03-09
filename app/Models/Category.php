<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Relationship with Posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function post()
    {
        return $this->hasMany(Post::class);
    }
}
