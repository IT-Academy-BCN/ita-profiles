<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagStoreRequest;
use App\Models\Tag;
use App\Http\Resources\Tag\TagResource;
use Illuminate\Http\JsonResponse;

class TagStoreController extends Controller
{
    public function __invoke(TagStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $tag = Tag::create($data);
        
        return response()->json([
            'message' => 'Tag successfully created.',
            'tag' => new TagResource($tag),
        ], 201);
    }
}
