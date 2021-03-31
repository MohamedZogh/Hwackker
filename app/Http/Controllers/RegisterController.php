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
            'profile_picture' => 'required|image|mimes:jpeg,jpg,png,webp,gif',
            'username' => 'required|string|min:2|max:12',
            'birth_date' => 'date|before:14 years ago',
            'email' => 'required',
            'country' => 'required|string',
            'facebook_url' => 'required_without:twitter_url',
            'twitter_url' => 'required_without:facebook_url',
            'password' => 'required|confirmed',
            'recaptcha_token' => 'required'
        ]);

        $request->file('profile_picture')->store('public');
        $hashName = $request->file('profile_picture')->hashName();
        $fileUrl = url("storage/$hashName");
        $userData = $request->all();
        $userData['profile_picture'] = $fileUrl;
        unset($userData['_token']);
        unset($userData['password_confirmation']);
        unset($userData['recaptcha_token']);

        $user = User::forceCreate($userData);

        auth()->loginUsingId($user->id);

        return redirect()->route('user');
    }
}
