<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'sender_type',
        'receiver_id',
        'receiver_type',
        'subject',
        'body'
    ];

    // Polymorphic relationship for the sender
    public function sender()
    {
        return $this->morphTo();
    }

    // Polymorphic relationship for the receiver
    public function receiver()
    {
        return $this->morphTo();
    }
}
