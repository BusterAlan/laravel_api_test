<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

    public function register(Request $request) {

        //TODO: Validar los datos de entrada

        $user = new User();

        $user -> username = $request -> input('username');
        $user -> email = $request -> input('email');
        $user -> password = Hash::make($request -> input('password'));
        $user -> gender = $request->input('gender');
        $user -> save();

        return response() -> json(

            [

                "uservalidation" => "Usuario satisfactoriamente registrado",

            ],

            201

        );

    }

    public function login(Request $request) {

        //TODO: Validar los datos de entrada

        // Si el usuario estaba logeado, no volver a preguntar los datos

        if (Auth::check()) {

            return response() -> json(

                [

                    "userlogin" => "El usuario ya tiene acceso a la aplicación, validado previamente",

                ],

                200

            );

        }

        $credentials = [

            'email' => $request -> input('email'),
            'password' => $request -> input('password'),

        ];

        $remember = $request -> input('remember');

        if (Auth::attempt($credentials, $remember)) {

            $request -> session() -> regenerate();

            return response() -> json(

                [

                    "userlogin" => "El usuario tiene acceso a la aplicación, ya está totalmente validado",

                ],

                201

            );

        } else {

            return response() -> json(

                [

                    "userlogin" => "Usuario no encontrado y no validado, vuelva a intentarlo",

                ],

                401

            );

        }

    }

    public function logout(Request $request) {

        Auth::logout();

        $request -> session() -> invalidate();
        $request -> session() -> regenerateToken();

        return response() -> json(

            [

                "userexit" => "El usuario ha salido de la sesión con éxito",

            ],

            200

        );

    }

}

