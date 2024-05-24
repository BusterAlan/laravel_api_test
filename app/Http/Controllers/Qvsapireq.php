<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Qvsapireq extends Controller {

    public function store(Request $request) {

        $data = $request -> json() -> all();

        $id_userdata = $data['id_userdata'];
        $testnumber = $data['testnumber'];
        $testresult = $data['testresult'];

        DB::insert('insert into life_style_info (id_userdata, testnumber, testresult) values (?, ?, ?)', [$id_userdata, $testnumber, $testresult]);

        return response()->json(

            [
                'message' => 'Data stored successfully',

            ],

            201

        );

    }

}

