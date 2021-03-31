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
        $validated = $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,jpg,png,bmp,gif,svg|max:2048',
            'username' => 'required|string|min:2|max:12',
            'birth_date' => 'date|before:14 years ago',
            'email' => 'required',
            'country' => 'required|string',
            'facebook_url' => 'required_without:twitter_url',
            'twitter_url' => 'required_without:facebook_url',
            'password' => 'required|confirmed',
        ]);

        $request->file('profile_picture')->store('public');
        $hashName = $request->file('profile_picture')->hashName();
        $fileUrl = url("storage/$hashName");
        $userData = $request->all();
        $userData['profile_picture'] = $fileUrl;
        unset($userData['_token']);
        unset($userData['password_confirmation']);
        $user = User::forceCreate($userData);


        $user = User::forceCreate($request->except('_token', 'password_confirmation'));

        auth()->loginUsingId($user->id);

        return redirect()->route('user', ['username' => $user->username]);
    }
}
