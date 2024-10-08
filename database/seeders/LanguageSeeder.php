<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = ['Castellà', 'Català', 'Anglès', 'Francès', 'Alemany', 'Italià', 'Portuguès', 'Rus'];
        $levels = ['Bàsic', 'Intermedi', 'Avançat', 'Natiu'];

        foreach ($languages as $language) {
            foreach ($levels as $level) {
                DB::table('languages')->insert([
                    'id' => (string) Str::uuid(),
                    'name' => $language,
                    'level' => $level,
                ]);
            }
        }
    }

}
