<?php
declare(strict_types=1);

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class GetStudentImageController extends Controller
{
    private const PHOTOS_PATH = 'public/photos/';

    public function __invoke(Student $student)
    {
        $url = $student->photo ? Storage::url(self::PHOTOS_PATH . $student->photo): '';
        return response()->json(['photo'=>$url]);
    }

}
