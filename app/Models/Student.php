<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use App\Models\Resume;
use App\Models\JobOffer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resume(): HasOne
    {
        return $this->hasOne(Resume::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(related: Tag::class);
    }

    public function jobOffers(): BelongsToMany
    {
        return $this->belongsToMany(related: JobOffer::class);
    }
}
