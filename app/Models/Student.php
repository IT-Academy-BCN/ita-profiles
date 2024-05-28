<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function resume()
    {
        return $this->hasOne(Resume::class);
    }
}
