<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Resume;

class SpecializationListService
{
    public function execute()
    {
        return $this->getSpecializationList();
    }

    public function getSpecializationList(): array
    {
        return Resume::distinct()
            ->where('specialization', '!=', 'Not Set')
            ->pluck('specialization')
            ->toArray();
    }
}
