<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Project;
use App\Models\Student;
use App\Models\Bootcamp;
use App\Models\Language;
use App\Models\Collaboration;
use App\Models\AdditionalTraining;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Resume extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];
    protected $casts = [
        'modality' => 'array',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'language_resume', 'resume_id', 'language_id');
    }
    public function bootcamps(): BelongsToMany
    {
        return $this->belongsToMany(Bootcamp::class)->withPivot('end_date');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function additionalTrainings(): BelongsToMany
    {
        return $this->belongsToMany(AdditionalTraining::class);
    }

    public function collaborations(): BelongsToMany
    {
        return $this->belongsToMany(Collaboration::class, 'resume_collaboration', 'resume_id', 'collaboration_id');
    }
}
