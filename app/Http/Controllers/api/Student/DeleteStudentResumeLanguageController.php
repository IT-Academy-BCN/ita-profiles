<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Exceptions\{
    ResumeNotFoundException,
    StudentLanguageResumeNotFoundException,
    StudentNotFoundException
};
use Illuminate\Http\{
    JsonResponse,
};
use Illuminate\Support\Facades\{
    DB,
    Log
};

use App\Http\Controllers\Controller;
use App\Service\Student\DeleteStudentResumeLanguageService;

class DeleteStudentResumeLanguageController extends Controller
{
    private DeleteStudentResumeLanguageService $deleteStudentResumeLanguageService;

    public function __construct(DeleteStudentResumeLanguageService $deleteStudentResumeLanguageService)
    {
        $this->deleteStudentResumeLanguageService = $deleteStudentResumeLanguageService;
    }

    public function __invoke(string $studentId, string $languageId): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->deleteStudentResumeLanguageService->execute($studentId, $languageId);

            DB::commit();
            return response()->json([], 200);
        } catch (StudentNotFoundException | ResumeNotFoundException | StudentLanguageResumeNotFoundException $e) {
            DB::rollBack();
            Log::error('Exception:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json('No s\'ha pogut eliminat l\'idioma seleccionat, per favor voldria intentar-ho més tard.', 500);
        }
    }
}
