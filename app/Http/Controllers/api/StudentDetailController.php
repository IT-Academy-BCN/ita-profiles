<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;


class StudentDetailController extends Controller
{

    public function __invoke()
    {
        $data = file_get_contents(base_path('database/data/studentDetail.json'));

        return response()->json(json_decode($data, true));
    }
}
