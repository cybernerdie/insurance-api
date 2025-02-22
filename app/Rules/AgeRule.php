<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AgeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail("The :attribute is must be a string.");
            return;
        };

        collect(explode(',', $value))->each(function ($age) use ($fail) {
            if (!is_numeric($age) || (int)$age < 18 || (int)$age > 70) {
                $fail(':attribute must be numeric values between 18 and 70.');
                return false;
            }
        });
    }
}
