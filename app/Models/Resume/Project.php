<?php

declare(strict_types=1);

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
