<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_name',
    ];

    /**
     * The students that belong to the tag.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_has_tags', 'tag_id', 'student_id');
    }

    public function toArray(): array {
        $result = parent::toArray();
        $result['id'] = $this->getAttributeValue('id');
        return $result;
    }
}
