<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorreoController extends Controller {

    public function login(Request $request) {

        $correo = $request -> input('correo');
        $contraseña = $request -> input('contraseña');

        $usuario = DB::table('userdata')

            -> where('email', $correo)
            -> where('password', $contraseña)
            -> first();

        if ($usuario) {

            return response()->json([ "mensaje" => "Inicio de sesión exitoso" ], 200);

        } else {

            return response()->json([ "mensaje" => "Combinación de correo y contraseña incorrecta" ], 401);

        }

    }

}

