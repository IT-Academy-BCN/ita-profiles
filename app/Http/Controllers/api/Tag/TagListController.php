<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Service\TagListService;
use Illuminate\Http\JsonResponse;
use Exception;

class TagListController extends Controller
{
    private TagListService $tagListService;

    public function __construct(TagListService $tagListService)
    {
        $this->tagListService = $tagListService;
    }
    
    public function __invoke(): JsonResponse
    {
        try {
            $service = $this->tagListService->execute();
            return response()->json(['tags' => $service]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
