<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Qvsimccontroll extends Controller {

    public function other(Request $request) {

        $data = $request -> json() -> all();

        $id_userdata = $data['id_userdata'];
        $weight = $data['weight'];
        $height = $data['height'];
        $waist = $data['waist'];

        DB::insert('insert into bmi_calc_info (id_userdata, weight, height, waist) values (?, ?, ?, ?)', [$id_userdata, $weight, $height, $waist]);

        return response()->json(

            [
                'message' => 'Data stored successfully',

            ],

            201

        );

    }

}

