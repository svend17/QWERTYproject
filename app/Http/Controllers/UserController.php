<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show profile of user
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        return view('profile', ['user'=>$user]);
    }

    /**cd
     * Store image to project storage
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function image(Request $request, User $user)
    {
        if ($request->File()) {
            $user->img = $request->file('img')->storeAs($request->path(), Auth::id(), 'public');
            $user->save();
        }
        return back();
    }
}
