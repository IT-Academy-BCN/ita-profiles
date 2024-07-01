<?php

namespace App\Service\Tag;

use App\Models\Resume;

class DevelopmentListService
{
    public function execute(): array
    {
        return Resume::distinct()
            ->where('development', '!=', 'Not Set')
            ->pluck('development')
            ->toArray();
    }
}
