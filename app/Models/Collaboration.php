<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Collaboration extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = [ 'id'];

}
