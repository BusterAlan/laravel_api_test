<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller {

    public function register(Request $request) {

        // Validación de los datos

        $request -> validate([

            "name" => 'required',
            "email" => 'required|email|unique:users',
            "password" => 'required|confirmed',
            "photo" => 'nullable',
            "gender" => 'nullable'

        ]);

        // Alta del usuario

        $user = new User();
        $user -> name = $request -> name;
        $user -> email = $request -> email;
        $user -> password = Hash::make($request -> password);
        $user -> photo = $request -> photo;
        $user -> gender = $request -> gender;
        $user -> save();

        // Respuesta de la API

        return response($user, Response::HTTP_CREATED);

    }

    public function login(Request $request) {

        // Validar credenciales

        $credentials = $request -> validate([

            "email" => [ 'required', 'email' ],
            "password" => [ 'required' ]

        ]);

        if (Auth::attempt($credentials)) {

            $user = $request -> user();
            $token = $user -> createToken('token') -> plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);

            return response(

                ["token" => $token],
                Response::HTTP_ACCEPTED

            ) -> withoutCookie($cookie);

        } else {

            return response()->json(

                ["message" => "Error, credentials doesn't match"],
                Response::HTTP_UNAUTHORIZED

            );

        }

    }

    public function userProfile(Request $request) {

        return response()->json(

            ["userData" => auth() -> user()],
            Response::HTTP_ACCEPTED

        );

    }

    public function logout() {

        $cookie = Cookie::forget('cookie_token');
        return response()->json(

            ["message" => "Successfully log out for the user"],
            Response::HTTP_ACCEPTED

        ) -> withCookie($cookie);

    }

    public function allUsers() {

        $users = User::all();
        return response()->json(

            ["users" => $users],
            Response::HTTP_OK

        );

    }

}

