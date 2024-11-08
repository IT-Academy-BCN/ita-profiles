<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\TagCollection;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagListController extends Controller
{
    public function __invoke(): JsonResponse
    {

        $tags = Tag::all();
        return (new TagCollection($tags))->response()->setStatusCode(200);
    }
}
