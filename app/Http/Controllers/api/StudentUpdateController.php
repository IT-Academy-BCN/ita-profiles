<?php
declare(strict_types=1);
namespace App\Http\Controllers\api;

use App\Exceptions\ResumeNotFoundException;
use App\Http\Controllers\Controller;
use App\Service\Student\StudentUpdateService;
use Illuminate\Http\JsonResponse;
use App\Exceptions\StudentNotFoundException;
use App\Http\Requests\UpdateStudentRequest;

class StudentUpdateController extends Controller
{
    private StudentUpdateService $studentUpdateService;

    public function __construct(StudentUpdateService $studentUpdateService)
    {
        $this->studentUpdateService =$studentUpdateService;
    }
    function __invoke(UpdateStudentRequest $request, $studentId):JsonResponse
    {
        try {
            $service = $this->studentUpdateService->execute($request, $studentId);
            return response()->json(['data'=> [$service]], 200);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error inesperat'], 500);
        }
    }
}
