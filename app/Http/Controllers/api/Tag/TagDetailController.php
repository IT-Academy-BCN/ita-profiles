<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Resources\Tag\TagResource;
use Illuminate\Http\JsonResponse;


class TagDetailController extends Controller
{
    
    public function __invoke(Tag $tag): JsonResponse
    {
        return response()->json(new TagResource($tag), 200);
    }
}
