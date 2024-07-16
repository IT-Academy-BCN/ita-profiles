<?php
declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use Illuminate\Http\{
    JsonResponse,
    Request
};
use Illuminate\Support\Facades\{
    DB,
    Log,
    Storage
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

    public function __invoke(UpdateImageStudentRequest $request, string $studentId): JsonResponse
    {

        DB::beginTransaction();
        try {

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = $studentId . '.profile_photo.' . $file->hashName();
                $path = $file->storeAs('public/photos', $filename);
                $this->updateStudentImageService->execute($studentId, $filename);

                DB::commit();

                return response()->json([
                    'profile'=> 'La foto del perfil de l\'estudiant s\'actualitza correctament'
                ], 200);
            } else {
                throw new \Exception('No foto detectada');
            }
        } catch (StudentNotFoundException $e) {
            DB::rollBack();
            Log::error('Exception:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json($e->getMessage(), 404);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json('La foto del perfil de l\'estudiant no s\'ha pogut actualitzar, per favor intenteu-ho de nou', 500);
        }
    }
}
