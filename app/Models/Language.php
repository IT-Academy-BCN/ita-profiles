<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function resumes()
    {
        return $this->belongsToMany(Resume::class);
    }
}
