<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueTagsIdsRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (count($value) !== count(array_unique($value))) {
            $fail('El camp :attribute conté valors duplicats.');
            return;
        }

        $existingTagsCount = DB::table('tags')->whereIn('id', $value)->count();
        if ($existingTagsCount !== count($value)) {
            $fail('Un o més valors en el camp :attribute no existeixen a la taula de tags.');
        }
    }
}
