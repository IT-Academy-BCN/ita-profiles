<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Recruiter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];

    public function recruiters(): HasMany
    {
        return $this->hasMany(Recruiter::class);
    }
}
