<?php

namespace App\Http\Controllers;

use App\Models\Follows;
use App\Models\Hwack;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $request->has('search') ? $search = $request->get('search'): $search = "";
        if ($request->has('username')) {
            $displayButton = true;
            $user = User::all()->where('username', $request->get('username'))->first();
            if ($user['is_admin'] && $request->has('private') && $request->get('private') === 'true') {
                $conditions = [['user_id', '=', $user->id], ['content', 'LIKE', "%$search%"]];
            } else {
                $followedByConnectedUser =  Follows::where([['followed_id', '=', $user->id], ['follower_id', '=', auth()->user()->id]])->first();
                $connectedUserBysearchedUser = Follows::where([['followed_id', '=', auth()->user()->id ], ['follower_id', '=', $user->id]])->first();
                if ($followedByConnectedUser != null && $connectedUserBysearchedUser != null){
                    $conditions = [['user_id', '=', $user->id], ['content', 'LIKE', "%$search%"]];
                }
                else{
                    $conditions = [['user_id', '=', $user->id], ['private', '=', false], ['content', 'LIKE', "%$search%"]];
                }
            }
        }
        else{
            $displayButton = false;
            $user = auth()->user();
            if ($user['is_admin'] && $request->has('private') && $request->get('private') === 'true') {
                $conditions = [['content', 'LIKE', "%$search%"]];
            } else {
                $conditions = [['private', '=', false], ['content', 'LIKE', "%$search%"]];
            }
        }
        $hwacks = Hwack::where($conditions)->latest()->simplePaginate(10);
        $alreadyFollows = Follows::all()->where('followed_id', '=', $user->id);
        $usersFollowed = [];
        foreach ($alreadyFollows as $alreadyFollow){
            $userfollowed = User::where('id', $alreadyFollow->follower_id)->first();
            $usersFollowed[] = $userfollowed->username;
            if (auth()->user()->username == $userfollowed->username){
                $displayButton = false;
            }
        }
        return view('user', [
            'user' => $user,
            'hwacks' => $hwacks,
            'displayButton' => $displayButton,
            'usersFollowed' => $usersFollowed
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
