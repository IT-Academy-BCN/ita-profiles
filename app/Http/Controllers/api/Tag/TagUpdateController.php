<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Exceptions\TagNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagUpdateRequest;
use App\Service\Tag\TagUpdateService;
use Illuminate\Http\JsonResponse;
use Exception;

class TagUpdateController extends Controller
{
    private TagUpdateService $tagUpdateService;

    public function __construct(TagUpdateService $tagUpdateService)
    {
        $this->tagUpdateService = $tagUpdateService;
    }

    public function __invoke(TagUpdateRequest $request, int $tagId): JsonResponse
    {
        try {
            $service = $this->tagUpdateService->execute($request->validated(), $tagId);
            return response()->json(['tag' => $service]);
        } catch (TagNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
