<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsToMany(related: Student::class, foreignPivotKey: 'tag_id', relatedPivotKey: 'student_id');
    }

    public function projects()
    {
        return $this->belongsToMany(related: Project::class, foreignPivotKey: 'tag_id', relatedPivotKey: 'project_id');
    }

    public function toArray(): array {
        $result = parent::toArray();
        $result['id'] = $this->getAttributeValue('id');
        return $result;
    }
}
