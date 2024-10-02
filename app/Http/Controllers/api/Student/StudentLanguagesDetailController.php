<?php
declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageCollection;
use App\Models\Student;
use Illuminate\Http\JsonResponse;

class StudentLanguagesDetailController extends Controller
{
    public function __invoke(Student $student): JsonResponse
    {
        $languages = $student->resume?->languages ?? collect();
        return response()->json(new LanguageCollection(resource: $languages));
    }
}
