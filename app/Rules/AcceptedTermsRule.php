<?php

namespace App\Rules;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AcceptedTermsRule extends Rule
{
    private $acceptedValues = ['yes', 'on', true, 1]; 

    public function passes($attribute, $value): bool
    {
        $request = app(Request::class);
        return in_array($request->input($attribute), $this->acceptedValues);
    }

    public function message(): string
    {
        return 'Has de acceptar els termes i condicions.';
    }
}
