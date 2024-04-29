<?php

declare(strict_types=1);

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * Get the projects for the company.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
