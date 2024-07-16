<?php
declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use Illuminate\Http\{
    JsonResponse,
    Request
};
use Illuminate\Support\Facades\{
    Log
};

use App\Http\Controllers\Controller;
use App\Exceptions\StudentNotFoundException;
use App\Service\Student\UpdateStudentImageService;
use App\Http\Requests\UpdateImageStudentRequest;


class UpdateStudentImageController extends Controller
{
    private UpdateStudentImageService $updateStudentImageService;

    public function __construct(UpdateStudentImageService $updateStudentImageService)
    {
        $this->updateStudentImageService = $updateStudentImageService;
    }

    public function __invoke(UpdateImageStudentRequest $request, string $studentID): JsonResponse
	{

		try {

			$file = $request->file('photo');
			$filename = $this->updateStudentImageService->createImageNameByStudentIDAndFileHash($studentID, $file->hashName());
			$this->updateStudentImageService->storePhotoInStorageByFileName($file, $filename);
			$this->updateStudentImageService->updateStudentImagePathInDatabaseByStudentID($studentID, $filename);


			return response()->json([
				'profile' => 'La foto del perfil de l\'estudiant s\'actualitza correctament'
			], 200);


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
			return response()->json('La foto del perfil de l\'estudiant no s\'ha pogut actualitzar, per favor intenteu-ho de nou', 500);

		}
	}
}
