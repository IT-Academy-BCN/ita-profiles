<?php
declare(strict_types=1);

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

    protected $attributes = [
        'read' => false,
    ];

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver', 'id');
    }
}
