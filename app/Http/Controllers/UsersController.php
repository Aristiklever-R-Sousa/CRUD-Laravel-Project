<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public static function login(Request $request) {
        if(
            $request->email == "" ||
            $request->password == ""
        ) {
            echo "<script> window.alert('Email ou senha não foram informados!') </script>";
            return view('home');
        }

        $email = $request->email;
        $password = $request->password;
        
        $user = User::where('email', $email)
                ->where('password', $password)
                ->get();
        
        if(count($user) > 0) {
            @session_start();
            $_SESSION['id_user'] = $user[0]->id;
            $_SESSION['name_user'] = $user[0]->name;
            $_SESSION['email_user'] = $user[0]->email;

            return redirect()->route('consults.get.index');
        }

        echo "<script language='javascript'> window.alert('Dados Incorretos!')</script>";
        return view('home');

    }

    public static function logout() {
        @session_start();
        @session_destroy();
        return redirect()->route('user.get.login');
    }
}
