<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagStoreRequest;
use App\Service\Tag\TagStoreService;
use Illuminate\Http\JsonResponse;
use Exception;

class TagStoreController extends Controller
{
    private TagStoreService $tagStoreService;

    public function __construct(TagStoreService $tagStoreService)
    {
        $this->tagStoreService = $tagStoreService;
    }

    public function __invoke(TagStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $tagResource = $this->tagStoreService->execute($data);

        return response()->json([
            'message' => 'Tag successfully created.',
            'tag' => $tagResource
        ], 201);
    }
}
