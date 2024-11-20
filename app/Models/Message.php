<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'receiver',
        'subject',
        'body'
    ];

    protected $casts = [
        'id' => 'uuid',
        'read' => 'boolean',
    ];

    protected $attributes = [
        'read' => false,
    ];

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver', 'id');
    }
}
