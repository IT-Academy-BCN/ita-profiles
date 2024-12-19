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
            $fail('The field :attribute contains duplicate values.');
            return;
        }

        $existingTagsCount = DB::table('tags')->whereIn('id', $value)->count();
        if ($existingTagsCount !== count($value)) {
            $fail('One or more values in the field :attribute do not exist in the tags table.');
        }
    }
}
