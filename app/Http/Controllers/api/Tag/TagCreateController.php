<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagCreateRequest;
use App\Service\Tag\TagCreateService;
use Illuminate\Http\JsonResponse;
use Exception;

class TagCreateController extends Controller
{
    private TagCreateService $tagCreateService;

    public function __construct(TagCreateService $tagCreateService)
    {
        $this->tagCreateService = $tagCreateService;
    }

    public function __invoke(TagCreateRequest $request): JsonResponse
    {
        try {
            $service = $this->tagCreateService->execute($request->validated());
            return response()->json(['tag' => $service], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
