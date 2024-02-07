<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

class SpecializationListController extends Controller
{
    public function __invoke()
    {
        $specialization_list = ['Frontend', 'Backend', 'Fullstack', 'Data Science', 'None'];

        return response()->json($specialization_list);
    }
}
