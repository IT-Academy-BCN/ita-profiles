<?php

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateStudentLanguagesController extends Controller
{
  public function __invoke(string $studentId, Request $request): JsonResponse
  {
    try {
      // Validar la solicitud (misma lógica que antes)

      $data = $request->validate([
        'language_name' => 'required|string',
        'language_level' => 'required|string|in:Bàsic,Intermedi,Avançat,Natiu',
      ]);

      Log::info('Request received', ['studentId' => $studentId, 'requestData' => $request->all()]);

      // Buscar el estudiante (misma lógica que antes)

      $student = Student::find($studentId);

      // Verificar si el estudiante se encontró (misma lógica que antes)

      Log::info('Student found', ['student' => $student]);

      // Obtener el currículum del estudiante (misma lógica que antes)

      $resume = $student->resume;

      // Verificar si el currículum se encontró (misma lógica que antes)

      Log::info('Resume found', ['resume' => $resume]);

      // Buscar el lenguaje por nombre y nivel (misma lógica que antes)

      $language = $resume->languages()
        ->where('language_name', $data['language_name'])
        ->where('language_level', $data['language_level'])
        ->first();

      // Verificar si el lenguaje se encontró (misma lógica que antes)

      Log::info('Language found', ['language' => $language]);

      // Actualizar el pivote language_resume (método actualizado)
      $resume->languages()->attach($language->id, ['language_level' => $data['language_level']]);

      Log::info('Language level updated', ['language_id' => $language->id]);

      // Retornar los lenguajes actualizados del currículum (misma lógica que antes)

      return response()->json($resume->languages, 200);
    } catch (\Exception $e) {
      Log::error('An error occurred', ['exception' => $e]);
      return response()->json(['error' => 'An error occurred while processing the request'], 500);
    }
  }
}
