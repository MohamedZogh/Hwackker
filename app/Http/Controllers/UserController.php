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
            $hwacks = Hwack::where('user_id', $user->id, 'private', false)->latest()->simplePaginate(100);
            return view('user', [
                'user' => $user,
                'hwacks' => $hwacks,
            ]);
        }

        $user = auth()->user();
        $hwacks = Hwack::where('private', false)->latest()->simplePaginate(100);
        return view('user', [
            'user' => $user,
            'hwacks' => $hwacks,
        ]);
    }

    public function createHwack(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,webp,gif',
            'content' => 'required|string|max:500',
            'private' => 'required',
        ]);

        $user = User::find($request->get('user_id'));

        Hwack::forceCreate($request->except('_token'));

        return redirect()->route('user', ['username' => $user->userame]);
    }
}
