<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;

class StudentCollaborationController extends Controller
{
    public function __invoke()
    {
        
        $data = file_get_contents(base_path('database/data/studentCollaborations.json'));
        
        $decodedData = json_decode($data, true);
        
        return response()->json($decodedData);

       /*  $allCollaborations = array_merge(...array_column($decodedData, 'collaborations'));
         
        return response()->json(['collaborations' => $allCollaborations]); */

    }
}
