<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Service\Tag\DevelopmentListService;
use Illuminate\Http\JsonResponse;

class DevelopmentListController extends Controller
{
    private DevelopmentListService $developmentListService;

    public function __construct(DevelopmentListService $developmentListService)
    {
        $this->developmentListService = $developmentListService;
    }

    public function __invoke(): JsonResponse
    {
        $data = $this->developmentListService->execute();
        return response()->json($data, 200);
    }
}


