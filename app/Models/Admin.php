<?php

namespace App\Models;

use App\Exceptions\EmptyAdminListException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @throws EmptyAdminListException
     */
    public static function findAll(): Collection
    {
        $admins = Admin::all();

        if ($admins->isEmpty()) {
            throw new EmptyAdminListException();
        }

        return $admins;
    }
}
