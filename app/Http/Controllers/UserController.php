<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    private const MESSAGES = [
        'required' => 'Preencha todos os campos!',
        'email' => 'O campo email não está dentro dos padrões.',
        'same' => 'O campo senha não bate com a confirmação!',
        'unique' => 'O email informado já existe!',
        'min' => 'O campo :attribute precisa de, pelo menos, :min caracteres.'
    ];

    public function insertView()
    {
        return view('new.user.user-new');
    }

    public function insert(Request $request) {
        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => ['bail', 'required'],
                'email' => ['bail', 'required', 'email:rfc,dns', 'unique:App\Models\User,email'],
                'password' => ['bail', 'min:8', 'required'],
                'password-confirm' => ['required', 'same:password']
            ],
            UserController::MESSAGES
        )->validate();
        
        $user = new User();
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        
        $user->save();

        Auth::login($user);

        return redirect()->route('consults.get.view');
    }

}
