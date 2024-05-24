<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Service\SpecializationListService;
use Illuminate\Http\JsonResponse;
use Exception;

class SpecializationListController extends Controller
{
    private SpecializationListService $specializationListService;

    public function __construct(SpecializationListService $specializationListService) {

        $this->specializationListService = $specializationListService;
    }

    public function __invoke(): jsonResponse
    {
        try {
            $service = $this->specializationListService->execute();
            return response()->json($service);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
