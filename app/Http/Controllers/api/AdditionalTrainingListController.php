<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Service\Student\AdditionalTrainingListService;
use Exception;
use Illuminate\Http\JsonResponse;

class AdditionalTrainingListController extends Controller
{
    private AdditionalTrainingListService $additionalTrainingListService;

    public function __construct(AdditionalTrainingListService $additionalTrainingListService) {
        $this->additionalTrainingListService = $additionalTrainingListService;
    }

    public function __invoke($uuid): JsonResponse
    {
        try {
            $service = $this->additionalTrainingListService->execute($uuid);
            return response()->json($service);
        } catch (Exception $exception) {
            $responseCode = $exception->getCode() > 0 ? $exception->getCode() : 500;
            return response($exception->getMessage(), $responseCode)->json();
        }
    }
}
