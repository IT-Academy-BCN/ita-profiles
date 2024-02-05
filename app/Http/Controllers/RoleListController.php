<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class RoleListController extends Controller
{
    public function getRoleList()
    {
        $filePath = base_path('database/data/students.json');

        if (File::exists($filePath)) {
            $jsonContent = File::get($filePath);

            $role_list = json_decode($jsonContent, true);

            return response()->json($role_list);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
}
