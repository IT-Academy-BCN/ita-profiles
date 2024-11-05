<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagUpdateRequest;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagUpdateController extends Controller
{
    public function __invoke(TagUpdateRequest $request, Tag $tag): JsonResponse
    {
        $data = $request->validated();

        $tag->update($data);

        return response()->json([
            'tag' => 'L\'etiqueta s\'ha actualitzat correctament.',
        ]);
    }
}
