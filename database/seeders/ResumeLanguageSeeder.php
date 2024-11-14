<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\Resume;

class ResumeLanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languageIds = Language::pluck('id')->toArray();
        $languageIds[] = null;

        $resumes = Resume::all();

        foreach ($resumes as $resume) {
            $selectedLanguage = $languageIds[array_rand($languageIds)];

            if ($selectedLanguage !== null) {
                $this->attachLanguage($resume, $selectedLanguage);
                $this->attachSecondLanguage($resume, $languageIds, $selectedLanguage);
            }
        }
    }

    private function attachLanguage($resume, $selectedLanguage): void
    {
        $resume->languages()->attach($selectedLanguage);
    }

    private function attachSecondLanguage($resume, $languageIds, $selectedLanguage): void
    {
        if (rand(1, 4) === 1 && $selectedLanguage !== null) {
            $eligibleLanguages = array_diff($languageIds, [$selectedLanguage, null]);
            if (!empty($eligibleLanguages)) {
                do {
                    $additionalLanguage = $eligibleLanguages[array_rand($eligibleLanguages)];
                    $selectedLanguageModel = Language::find($selectedLanguage);
                    $additionalLanguageModel = Language::find($additionalLanguage);
                } while ($additionalLanguage === $selectedLanguage ||
                        $additionalLanguageModel->name === $selectedLanguageModel->name);
                $this->attachLanguage($resume, $additionalLanguage);
            }
        }
    }
}
