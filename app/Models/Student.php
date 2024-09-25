<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use App\Models\Resume;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'surname',
        'photo',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function resume()
    {
        return $this->hasOne(Resume::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'student_has_tags', 'student_id', 'tag_id');
    }
}
