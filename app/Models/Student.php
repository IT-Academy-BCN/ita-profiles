<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subtitle',
        'about',
        'cv',
        'bootcamp',
        'end_date',
        'linkedin',
        'github',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'student_has_tags', 'student_id', 'tag_id');
    }

    public function resume(){
        return $this->hasOne(Resume::class);
    }

    /*public function projects(){
        $this->hasMany(Project::class);
    }*/

}
