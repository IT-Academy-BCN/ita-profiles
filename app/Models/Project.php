<?php

declare(strict_types=1);

namespace App\Models;

use App\Providers\ProjectRetrieved;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // We define a $dispatchEvents to listen to model events
    protected $dispatchesEvents = [
        'retrieved' => ProjectRetrieved::class,
    ];
}
