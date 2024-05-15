<?php

namespace App\Service;

use App\Models\Resume;

class DevelopmentListService
{
    public function execute(): array
    {
        return $this->getDevelopmentList();
    }

    public function getDevelopmentList(): array
    {
        return Resume::distinct()
            ->where('development', '!=', 'Not Set')
            ->pluck('development')
            ->toArray();
    }
}