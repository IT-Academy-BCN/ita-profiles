<?php

namespace App\Http\Controllers\api\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\JsonResponse;

class CreateCompanyController extends Controller
{
    public function __invoke($request): JsonResponse
    {
        $company = Company::create($request);

        return response()->json([
            'message' => "Company {$company->name} was created successfully",
        ], 200);
    }
}
