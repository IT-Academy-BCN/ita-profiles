<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Service\Tag\TagDetailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class TagDetailController extends Controller
{
    private TagDetailService $tagDetailsService;

    public function __construct(TagDetailService $tagDetailsService)
    {
        $this->tagDetailsService = $tagDetailsService;
    }

    public function __invoke($tagId): JsonResponse
    {
        try {
            $service = $this->tagDetailsService->execute($tagId);
            return response()->json(['data' => $service], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
