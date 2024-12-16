<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\DevelopmentListCollection;
use App\Models\Tag;


class DevelopmentListController extends Controller
{
    public function __invoke(Tag $tag): JsonResponse
    {
        $developments = $tag->resume?->development ?? collect();
        return response()->json(new developmentListCollection($developments));
    }
}

