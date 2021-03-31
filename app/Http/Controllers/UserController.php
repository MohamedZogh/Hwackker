<?php

namespace App\Http\Controllers;

use App\Models\Hwack;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('username')) {
            $user = User::all()->where('username', $request->get('username'))->first();

            return view('user', [
                'user' => $user,
                'hwacks' => Hwack::where('user_id', $user->id)->get()->sortByDesc('created_at'),
            ]);
        }

        $user = auth()->user();

        return view('user', [
            'user' => $user,
            'hwacks' => Hwack::limit(500)->get()->sortByDesc('created_at'),
        ]);
    }

    public function createHwack(Request $request)
    {
        $user = User::find($request->get('user_id'));

        Hwack::forceCreate($request->except('_token'));

        return redirect()->route('user', ['username' => $user->userame]);
    }
}
