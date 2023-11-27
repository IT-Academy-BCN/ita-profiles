<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AdminIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userid' => $this->user->id,
            'name' => Str::ucfirst($this->user->name),
            'surname' => Str::ucfirst($this->user->surname),
            'email' => Str::ucfirst($this->user->email),

        ];
    }
}
