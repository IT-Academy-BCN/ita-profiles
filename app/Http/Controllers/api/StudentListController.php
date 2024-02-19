<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Service\StudentListService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;

class StudentListController extends Controller
{

    private StudentListService $studentListService;

    public function __construct(StudentListService $studentListService)
    {
        $this->studentListService = $studentListService;

    }
    public function __invoke()
    {
            try{
                $data = $this->studentListService->execute();

                return response()->json($data,200);
            }catch(ModelNotFoundException $resumesNotFoundException){
                throw new HttpResponseException(response()->json([
                    'message' => $resumesNotFoundException->getMessage()], $resumesNotFoundException->getCode()));
            }
     
    }
}
