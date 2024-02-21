<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Resume;

class SpecializationListController extends Controller
{
    public function __invoke()
    {
        $specialization_list = Resume::distinct()
            ->where('specialization', '!=', 'Not Set')
            ->pluck('specialization')
            ->toArray();

        return response()->json($specialization_list);
    }
}
