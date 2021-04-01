<?php

namespace App\Http\Controllers;

use App\Models\Follows;
use App\Models\User;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public function follow(Request $request){
        try {
            $request->validate([
                'followed_id' => 'required|exists:users,id'
            ]);
            $followedId = (int) $request->get('followed_id');
            Follows::firstOrCreate(['follower_id' => auth()->user()->id, 'followed_id' => $followedId]);
            return true;
        }catch(\Exception $exception){
            return $exception->getMessage();
        }

    }
}
