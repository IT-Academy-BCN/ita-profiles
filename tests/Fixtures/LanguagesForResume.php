<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Illuminate\Support\Str;

class LanguagesForResume
{
    public static function createLanguagesForResume($resume, $count = 1)
    {
        $languages = [];

        for ($i = 0; $i < $count; $i++) {
            $language = $resume->languages()->create([
                'language_id' => Str::uuid(),
                'name' => 'Language ' . ($i + 1),
                'level' => 'Bàsic',
            ]);
            $languages[] = [
                'language_id' => $language->id,
                'name' => $language->name,
                'level' => $language->level,
            ];
        }

        return $languages;
    }
}
