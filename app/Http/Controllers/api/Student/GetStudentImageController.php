<?php
declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Service\Student\GetStudentImageService;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class GetStudentImageController extends Controller
{
    public function __construct(public GetStudentImageService $getStudentImageService){ }

    public function __invoke($studentId)
    {
        $this->getStudentImageService->execute();
        try {

            return response()->json([], 200);
        } catch (\Throwable $th) {
            
        }
    }
}
