<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdditionalTraining extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];

    public function resumes(): BelongsToMany
    {
        return $this->belongsToMany(Resume::class, 'additional_training_resume');
    }

}
