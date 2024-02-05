<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class RoleListController extends Controller
{
    public function getRoleList()
    {
        $filePath = base_path('database/data/role_list.json');

        if (File::exists($filePath)) {
            $jsonContent = File::get($filePath);

            $role_list = json_decode($jsonContent, true);

            return response()->json($role_list);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
}
