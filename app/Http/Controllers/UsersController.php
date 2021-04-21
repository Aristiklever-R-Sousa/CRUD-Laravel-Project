<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public static function login(Request $request) {
        $email = $request->email;
        $password = $request->password;
        
        $user = DB::table('users')
                ->where('email', '=', $email)
                ->where('password', '=', $password)
                ->get();
        
        if(count($user) > 0) {

            $consults = DB::table('consults')
                    ->join('doctors', 'doctors.id', '=', 'consults.doctor')
                    ->select('consults.*', 'doctors.name')
                    ->orderBy('consults.timeMarked', 'asc')
                    ->get();
                    
            foreach($consults as $consult) {
                $tmp = explode(' ', $consult->timeMarked);
                $date = explode('-', $tmp[0]);
                $hour = explode(':', $tmp[1]);
                
                $aux = $date[0];
                $date[0] = $date[2];
                $date[2] = $aux;
                
                $consult->timeMarked = "Dia " . implode("/", $date) . " às " . "$hour[0]:$hour[1]";
            }
            
            @session_start();
            $_SESSION['id_user'] = $user[0]->id;
            $_SESSION['name_user'] = $user[0]->name;
            $_SESSION['email_user'] = $user[0]->email;

            return view('consults.index', ['consults' => $consults]);
        }

        echo "<script language='javascript'> window.alert('Dados Incorretos!')</script>";
        return view('home');

    }

    public static function logout() {
        @session_start();
        @session_destroy();
        return view('home');
    }
}
