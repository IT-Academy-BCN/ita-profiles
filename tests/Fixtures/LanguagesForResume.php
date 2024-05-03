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
                'language_name' => 'Language ' . ($i + 1),
                'language_level' => 'Bàsic',
            ]);
            $languages[] = [
                'language_id' => $language->id,
                'language_name' => $language->language_name,
                'language_level' => $language->language_level,
            ];
        }

        return $languages;
    }
}
