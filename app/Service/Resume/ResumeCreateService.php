<?php


declare(strict_types=1);
namespace App\Service\Resume;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Resume;
use App\Models\Student;
use App\Http\Requests\ResumeRequest;
use App\Exceptions\DuplicateResumeException;

class ResumeCreateService{
    public function execute(ResumeRequest $request, $user): Resume
    {
        // Check if the user is authenticated
        if (!$user) {
            throw new \Exception('Unauthorized', 401);
        }
        $student = Student::find($user->id);

        // Check if the user already has a resume
        if ($student->resume()->exists()) {
            throw new DuplicateResumeException();
        }

        // Create a resume within a transaction
        return DB::transaction(function () use ($request, $user) {
            $tags_ids = json_encode($request->tags_ids);

            $resume = new Resume();
            $resume->student_id = $user->id;
            $resume->subtitle = $request->subtitle;
            $resume->linkedin_url = $request->linkedin_url;
            $resume->github_url = $request->github_url;
            $resume->tags_ids = $tags_ids;
            $resume->specialization = $request->specialization;
            $resume->save();

            return $resume;
        });
    }
}