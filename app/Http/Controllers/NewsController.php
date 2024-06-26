<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller {

    public function getNews() {

        $info = DB::select(

            'select

            titleNew,
            subtitleNew,
            imageCover,
            linkRelated

            from newsinfo'

        );

        return response() -> json(

            $info,
            Response::HTTP_OK

        );

    }

}

