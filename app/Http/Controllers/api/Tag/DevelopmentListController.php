<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Service\Tag\DevelopmentListService;
use Illuminate\Http\JsonResponse;
use Exception;

class DevelopmentListController extends Controller
{
    private DevelopmentListService $developmentListService;

    public function __construct(DevelopmentListService $developmentListService)
    {
        $this->developmentListService = $developmentListService;
    }

    public function __invoke(): JsonResponse
    {
        try {
            $data = $this->developmentListService->execute();
            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
