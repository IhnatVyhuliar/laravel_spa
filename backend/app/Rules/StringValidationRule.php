<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StringValidationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!preg_match("/^[a-zA-Z0-9]*$/", $value)){
            $fail('String should be alphanumeric');

        }
        if (strlen($value) < 2 || strlen($value) > 25)
        {
            $fail('String should mbe minimum 2 and max 25 characters');
        }

    }
}
