<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Service\AdditionalTrainingService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
class AdditionalTrainingListController extends Controller
{
    protected $additionalTrainingService;

    public function __construct(AdditionalTrainingService $additionalTrainingService)
    {
        $this->additionalTrainingService = $additionalTrainingService;
    }

    public function __invoke($uuid)
    {
        try {
            $additionalTrainingDetail = [
                'additional_trainings' => $this->additionalTrainingService->getAdditionalTrainingDetails($uuid),
            ];
            return response()->json($additionalTrainingDetail);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found.'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
    }
}
