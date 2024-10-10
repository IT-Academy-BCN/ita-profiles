<?php

namespace App\Models;

use App\Models\Resume;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Collaboration extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];

    public function resumes(): BelongsToMany
    {
        return $this->belongsToMany(Resume::class, 'resume_collaboration', 'resume_id', 'collaboration_id');
    }
}
