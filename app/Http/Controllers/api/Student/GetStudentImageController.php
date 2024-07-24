<?php
declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Exceptions\StudentNotFoundException;
use App\Http\Controllers\Controller;
use App\Service\Student\GetStudentImageService;
use Illuminate\Support\Facades\Log;

class GetStudentImageController extends Controller
{
    public function __construct(public GetStudentImageService $getStudentImageService){ }

    public function __invoke(string $studentId)
    {
        try {
            $studentPhoto = $this->getStudentImageService->execute($studentId);
                return response()->json($studentPhoto, 200);
		} catch (StudentNotFoundException $e) {
			Log::error('Exception:', [
				'exception' => $e->getMessage(),
				'trace' => $e->getTraceAsString(),
			]);
			return response()->json($e->getMessage(), 404);
		} catch (\Exception $e) {
			Log::error('Exception:', [
				'exception' => $e->getMessage(),
				'trace' => $e->getTraceAsString(),
			]);
			return response()->json('Error del servidor', 500);
		}
    }
}
