<?php
declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Models\Language;
use App\Models\Student;
use Exception;
use App\Http\Controllers\Controller;
use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\LanguageAlreadyExistsException;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AddStudentLanguageRequest;

class AddStudentLanguageController extends Controller
{

    /**
     * @throws LanguageAlreadyExistsException
     * @throws ResumeNotFoundException
     * @throws Exception
     */
    public function __invoke(AddStudentLanguageRequest $request, Student $student): JsonResponse
    {
        $data = $request->validated();
        $resume = $student->resume ?? throw new ResumeNotFoundException($student->id);
        $language = Language::find($data['language_id']) ?: throw new Exception;

        if ($resume->languages()->where('language_id', $language->id)->exists()) {

            $languageId = $language->id;
            $studentId = $resume->student_id;

            throw new LanguageAlreadyExistsException($languageId, $studentId);
        }

        $resume->languages()->attach($language->id);

        return response()->json(['message' => 'L\'idioma s\'ha afegit']);

    }
}
