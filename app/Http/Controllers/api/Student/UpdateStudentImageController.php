<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateImageStudentRequest;

class UpdateStudentImageController extends Controller
{
    private string $photo_infix = '.profile_photo.';
    private string $photos_path = 'public/photos/';

    public function __invoke(UpdateImageStudentRequest $request, Student $student): JsonResponse
    {
        $this->authorize('update', $student);

        $file = $request->file('photo');

        $filename = time() . '.' . $student->id . $this->photo_infix . $file->hashName();

        if ($student->photo) {
            Storage::delete($this->photos_path . $student->photo);
        }

        $file->storeAs($this->photos_path, $filename);

        $student->photo = $filename;
        $student->save();

        return response()->json(['message' => 'The image has been updated successfully']);
    }
}
