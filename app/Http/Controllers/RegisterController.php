<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function show()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|mimes:jpg,png,gif,webp',
            'username' => 'required',
            'birth_date' => 'date|before:14 years ago',
            'email' => 'required',
            'country' => 'required',
            'facebook_url' => 'required',
            'twitter_url' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        $user = User::forceCreate($request->except('_token', 'password_confirmation'));

        auth()->loginUsingId($user->id);

        return redirect()->route('user', ['username' => $user->username]);
    }
}
