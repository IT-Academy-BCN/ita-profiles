<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];
    public $timestamps = false;


    public function tags()
    {
        return $this->belongsToMany(related: Tag::class, table: 'tag_project', foreignPivotKey: 'project_id', relatedPivotKey: 'tag_id');
    }
}
