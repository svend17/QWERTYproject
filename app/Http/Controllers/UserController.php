<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show profile of user
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('profile', ['user'=>$user]);
    }

    /**
     * Store image to project storage
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function image(Request $request, User $user): RedirectResponse
    {
        if ($request->File()) {
            $user->img = $request->file('img')->storeAs($request->path(), Auth::id(), 'public');
            $user->save();
        }
        return back();
    }
}
