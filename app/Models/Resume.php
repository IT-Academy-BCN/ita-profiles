<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class Resume extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * @var Carbon|mixed
     */
    protected $guarded = ['id'];
    protected $casts = [
        'modality' => 'array',
        'github_updated_at' => 'datetime',
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
        return $this->belongsToMany(Project::class)
            ->withPivot('created_at', 'updated_at')
            ->withTimestamps();
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
