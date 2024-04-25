<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Bootcamp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BootcampSeeder extends Seeder
{
    public function run(): void
    {
        $bootcamps = [
            [
                'name' => 'Reskilling - Back End Java',
                'id' => (string) Str::uuid(),
            ],
            [
                'name' => 'Reskilling - Back End Nodejs',
                'id' => (string) Str::uuid(),
            ],
            [
                'name' => 'Reskilling - Data Analytics',
                'id' => (string) Str::uuid(),
            ],
            [
                'name' => 'Reskilling - Front End Angular',
                'id' => (string) Str::uuid(),
            ],
            [
                'name' => 'Reskilling - Front End React',
                'id' => (string) Str::uuid(),
            ],
            [
                'name' => 'Reskilling - Full Stack PHP',
                'id' => (string) Str::uuid(),
            ],
            [
                'name' => 'Big Data',
                'id' => (string) Str::uuid(),
            ],
            [
                'name' => 'Business Intelligence',
                'id' => (string) Str::uuid(),
            ],
        ];

        foreach ($bootcamps as $bootcamp) {
            Bootcamp::create($bootcamp);
        }
    }
}
