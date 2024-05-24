<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Qvshealthstate extends Controller {

    public function mine(Request $request) {

        $data = $request -> json() -> all();

        $id_userdata = $data['id_userdata'];
        $aPsiastolic = $data['aPsiastolic'];
        $aPdiastolic = $data['aPdiastolic'];
        $glucose = $data['glucose'];
        $colesterolT = $data['colesterolT'];
        $HDL = $data['HDL'];
        $LDL = $data['LDL'];
        $triglycerides = $data['triglycerides'];

        DB::insert(

            'insert into health_state_calc_info (id_userdata, aPsiastolic, aPdiastolic, glucose, colesterolT, HDL, LDL, triglycerides) values (?, ?, ?, ?, ?, ?, ?, ?)',
            [$id_userdata, $aPsiastolic, $aPdiastolic, $glucose, $colesterolT, $HDL, $LDL, $triglycerides]

        );

        return response()->json(

            [
                'message' => 'Data stored successfully',

            ],

            201

        );

    }

}

