<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

class SpecializationListController extends Controller
{
    public function __invoke()
    {
        $specialization_list = ['Frontend', 'Backend', 'Fullstack', 'Data Science', 'None'];

        $filtered_list = array_diff($specialization_list, ["None"]);

        return response()->json($filtered_list);
    }
}
