<?php

namespace App\Http\Controllers;

use App\Models\Hwack;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('username')) {
            $user = User::all()->where('username', $request->get('username'))->first();
            if ($user['is_admin'] && $request->has('private') && $request->get('private') === 'true') {
                $hwacks = Hwack::where('user_id', $user->id)->latest()->simplePaginate(100);
            } else {
                $hwacks = Hwack::where('user_id', $user->id, 'private', false)->latest()->simplePaginate(100);
            }
            return view('user', [
                'user' => $user,
                'hwacks' => $hwacks,
            ]);
        }

        $user = auth()->user();
        if ($user['is_admin'] && $request->has('private') && $request->get('private') === 'true') {
            $hwacks = Hwack::latest()->simplePaginate(100);
        } else {
            $hwacks = Hwack::where('private', false)->latest()->simplePaginate(100);
        }
        return view('user', [
            'user' => $user,
            'hwacks' => $hwacks,
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
            $hwackPath = Storage::disk('public')->path('') . "hwack";
            if (!file_exists($hwackPath)){
                mkdir($hwackPath, 0777, true);
            }
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
