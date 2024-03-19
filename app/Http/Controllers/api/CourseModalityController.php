<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;


class CourseModalityController extends Controller
{
    public function __invoke()
    {
        $data = json_decode(file_get_contents(base_path('database/data/modality.json')), true);
        
        $modality = $data['modalities'][array_rand( $data['modalities'])];

        return response()->json([
            'modality' => $modality['name']
        ], 200);    

    }
}
