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
            // @TODO: Validate the request
        ]);

        $user = User::forceCreate($request->except('_token', 'password_confirmation'));

        auth()->loginUsingId($user->id);

        return redirect()->route('user', ['username' => $user->username]);
    }
}
