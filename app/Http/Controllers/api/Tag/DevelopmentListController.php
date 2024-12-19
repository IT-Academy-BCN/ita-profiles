<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Resources\DevelopmentListCollection;
use App\Models\Resume;
use Illuminate\Http\JsonResponse;

class DevelopmentListController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $developments = Resume::distinct()
        ->where('development', '!=', 'Not Set')
        ->pluck('development');

        return response()->json(new DevelopmentListCollection($developments));
    }
}
