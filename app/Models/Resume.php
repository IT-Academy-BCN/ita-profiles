<?php

namespace App\Models;

use App\Exceptions\UserNotAuthenticatedException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class Resume extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['student_id', 'subtitle', 'linkedin_url', 'github_url', 'tags_ids', 'specialization'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public static function updateResume($data, $id): Collection
    {
        $instance = new self();
        $resume = $instance->validateAndRetrieveResume($id);
        $resume->update($data);
        $resume->save();

        return $resume;

    }

    public static function deleteResume($id)
    {
        $instance = new self();
        $resume = $instance->validateAndRetrieveResume($id);
        $resume->delete();
    }

    private function validateAndRetrieveResume($id): Collection
    {
        $resumeId = Auth::user()->student->resume->id;
        $resume = Resume::find($id);
        if (! $resume) {
            throw new ModelNotFoundException(
                __('Currículum no trobat'), 404);
        }
        if ($resumeId != $resume->id) {
            throw new UserNotAuthenticatedException();
        }

        return $resume;
    }
}
