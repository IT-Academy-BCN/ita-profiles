<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'language_resume', 'resume_id', 'language_id');
    }
    public function bootcamps()
    {
        return $this->belongsToMany(Bootcamp::class)->withPivot('end_date');
    }
}
