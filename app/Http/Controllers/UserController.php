<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show profile of user
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(int $id)
    {
        $user = User::find($id);
        return view('profile', ['user'=>$user]);
    }

    /**cd
     * Store image to project storage
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function image(Request $request, int $id)
    {
        if ($request->File()) {
            $user = User::find($id);
            $user->img = $request->file('img')->storeAs($request->path(), $request->user()->id, 'public');
            $user->save();
        }
        return back();
    }
}
