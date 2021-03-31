<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        auth()->loginUsingId($user->id);

        return redirect()->route('user', ['username' => $user->username]);

    }
}
