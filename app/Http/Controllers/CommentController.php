<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store new comment
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Comment::create([
            'massage' => request('massage'),
            'post_id' => request('post_id'),
            'user_id' => Auth::id() ?? null,
            'parent_id' => request('parent_id') ?? null
        ]);
        return back()->with('success', 'Comment added');
    }
}
