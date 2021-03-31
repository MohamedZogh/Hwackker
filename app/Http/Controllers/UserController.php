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
            'hwacks' => Hwack::limit(5)->get()->sortByDesc('created_at'),
        ]);
    }

    public function createHwack(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,jpg,png,webp,gif',
            'content' => 'required|max:500',
        ]);

        $hwackData = $request->all();
        if ($request->hasFile('image')) {
            $request->file('image')->store('public/hwack');
            $hashName = $request->file('image')->hashName();
            $fileUrl = url("storage/hwack/$hashName");
            $hwackData['image'] = $fileUrl;
        }
        if (array_key_exists('private', $hwackData)) {
            $hwackData['private'] = true;
        }
        unset($hwackData['_token']);

        $user = User::find($request->get('user_id'));

        Hwack::forceCreate($hwackData);

        return redirect()->route('user', ['username' => $user->username]);
    }
}
