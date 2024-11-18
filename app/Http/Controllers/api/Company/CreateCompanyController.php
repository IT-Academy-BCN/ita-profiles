<?php

namespace App\Http\Controllers\api\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreCompanyRequest;

class CreateCompanyController extends Controller{

    public function __invoke(StoreCompanyRequest $request): JsonResponse
    {
        $data = $request->validated();
        $company = Company::create($data);

        return response()->json([
            'message' => "Company {$company->name} was created successfully",
        ], 200);
    }
}
