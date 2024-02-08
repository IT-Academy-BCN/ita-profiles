<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = ['student_id', 'subtitle', 'linkedin_url', 'github_url', 'tags_ids', 'specialization'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'id', 'student_id');
    }
}
