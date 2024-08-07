<?php

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Service\Student\StudentListService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;


class StudentListController extends Controller
{
    private StudentListService $studentListService;

    public function __construct(StudentListService $studentListService)
    {
        $this->studentListService = $studentListService;
    }

    public function __invoke(Request $request)
    {
        try {
            $specializationsString = $request->get('specialization');
            $specializations = $specializationsString ? explode(',', $specializationsString) : null;

            $tagsString = $request->get('tags');
            $tags = $tagsString ? explode(',', $tagsString) : null;

            $data = $this->studentListService->execute($specializations, $tags);

            return response()->json($data, 200);
        } catch (ModelNotFoundException $resumesNotFoundException) {
            throw new HttpResponseException(response()->json([
                'message' => $resumesNotFoundException->getMessage()
            ], $resumesNotFoundException->getCode()));
        }
        /*El método __invoke devuelve un array de coincidencias en formato JSON, utilizando el servicio
        'studentListService' y teniendo en cuenta los parámetros de la solicitud. Además, devuelve un mensaje de 
        error en caso de alguna excepción.*/
    }
}
