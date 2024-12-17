<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateImageStudentRequest;
use Illuminate\Support\Str;

class AddStudentImageController extends Controller
{
    private string $photos_path = 'public/photos/';

    public function __invoke(UpdateImageStudentRequest $request, Student $student): JsonResponse
    {
        $this->authorize('update', $student);

        $file = $request->file('photo');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $oldPhoto = $student->photo;

        $file->storeAs($this->photos_path, $filename);

        $student->photo = $filename;
        $student->save();

        if ($oldPhoto) {
            Storage::delete($this->photos_path . $oldPhoto);
        }

        return response()->json([
            'message' => 'Image added successfully',
            'photo' => Storage::url($this->photos_path . $filename),
        ]);
    }
}
