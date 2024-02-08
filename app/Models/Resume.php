<?php

namespace App\Models;

use App\Exceptions\UserNotAuthenticatedException;
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
        return $this->belongsTo(Student::class, 'id', 'student_id');
    }
}
