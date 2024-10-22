<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recruiter extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id', 'role'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function jobOffers(): HasMany
    {
        return $this->hasMany(JobOffer::class);
    }
}
