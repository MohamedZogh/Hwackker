<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            // 'password' => $request->get('password'),
        ])->first();
        if ($user) {

            $hashedPwd = Hash::check($request->get('password'), $user->password);
            if ($hashedPwd) {
                auth()->loginUsingId($user->id);

                return redirect()->route('user');
            } else {
                return back()->withErrors([
                    'message' => 'Your username or password is incorrect.'
                ]);
            }
        } else {
            return back()->withErrors([
                'message' => 'Your need to register before login.'
            ]);
        }
    }
}
