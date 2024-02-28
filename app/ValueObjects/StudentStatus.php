<?php

declare(strict_types=1);

namespace App\ValueObjects;

enum StudentStatus: string
{
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    case IN_A_BOOTCAMP = 'In a Bootcamp';
    case IN_A_JOB = 'In a Job';
}
