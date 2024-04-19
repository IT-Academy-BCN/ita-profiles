<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Bootcamp;
use Illuminate\Database\Seeder;

class BootcampSeeder extends Seeder
{
    public function run(): void
    {
        Bootcamp::factory(5)->create();
    }
}
