<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    private const MESSAGES = [
        'required' => 'Preencha todos os campos!'
    ];

    public static function login(Request $request) {
        $validatedData = Validator::make(
            $request->all(),
            [
                'email' => ['bail', 'required'],
                'password' => ['required']
            ],
            UsersController::MESSAGES
        )->validate();
        
        $user = User::where('email', $request->email)
                ->where('password', $request->password)
                ->get();
        
        if(count($user) > 0) {
            @session_start();
            $_SESSION['id_user'] = $user[0]->id;
            $_SESSION['name_user'] = $user[0]->name;
            $_SESSION['email_user'] = $user[0]->email;

            return redirect()->route('consults.get.index');
        }

        return view('home', [
            'error' => "Email ou senha informados estão incorretos!"
        ]);

    }

    public static function logout() {
        @session_start();
        @session_destroy();
        return redirect()->route('user.get.login');
    }
}
