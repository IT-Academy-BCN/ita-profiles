<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Service\Tag\TagStoreService;
use App\Http\Requests\TagRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class TagStoreController extends Controller
{
    private TagStoreService $tagStoreService;

    public function __construct(TagStoreService $tagStoreService)
    {
        $this->tagStoreService = $tagStoreService;
    }

    public function __invoke(TagRequest $request): JsonResponse
    {
        try {
            $service = $this->tagStoreService->execute($request->validated());
            return response()->json(['data' => $service, 'message' => __('Tag creada amb èxit.')],201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

}
