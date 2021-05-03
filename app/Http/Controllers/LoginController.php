<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private const MESSAGES = [
        'required' => 'Preencha todos os campos!',
        'request' => 'Email ou senha incorretos!'
    ];

    public function authenticate(Request $request)
    {
        $validatedData = Validator::make(
            $request->all(),
            [
                'email' => ['bail', 'required'],
                'password' => ['required']
            ],
            LoginController::MESSAGES
        )->validate();

        // return print_r(json_encode([
        //    'Pass?' => Hash::make($request->password),
        //    'Accepted?' => Auth::attempt([
        //                     'email' => $request->email,
        //                     'password' => $request->password
        //                 ])
        // ]));
        // Auth::attempt($credentials)
        if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])
        ) {

            $request->session()->regenerate();

            return redirect()->intended('consults');
        }

        return back()->withErrors([
            'request' => LoginController::MESSAGES['request']
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
