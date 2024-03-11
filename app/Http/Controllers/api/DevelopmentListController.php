<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DevelopmentListController extends Controller
{
    public function __invoke()
    {
        $data = file_get_contents(base_path('database/data/development.json'));
        $data = json_decode($data, true);
        return response()->json($data['development'], 200);
    }
}
