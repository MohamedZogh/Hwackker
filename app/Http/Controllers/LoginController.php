<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function show(Request $request)
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $user = User::where([
            'username' => $request->get('username'),
            'password' => $request->get('password'),
        ])->first();

        auth()->loginUsingId($user->id);

        return redirect()->route('user', ['username' => $user->username]);
    }
}
