<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];
    protected $casts = [
        'modality' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

