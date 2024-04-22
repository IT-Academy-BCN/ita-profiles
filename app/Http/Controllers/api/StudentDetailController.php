<?php
declare(strict_types=1); 
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentDetailController extends Controller
{
    function __invoke(Request $request,$student_id):JsonResponse
    {
        try {
            $studentDetails = Resume::where('student_id', $student_id)->get();

            if ($studentDetails->isEmpty()) {
                throw new ModelNotFoundException();
            }

            return response()->json($studentDetails, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No se encontró ningún estudiante con el ID especificado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Se produjo un error inesperado'], 500);
        }
    }  
}
