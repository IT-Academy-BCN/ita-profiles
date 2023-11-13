<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
        'endDate',
        'linkedin',
        'github',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*public function tags() {
        $this->hasMany(Tag::class);
    }


    public function projects(){
        $this->hasMany(Project::class);
    }*/

} 