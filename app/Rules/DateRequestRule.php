<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DateRequestRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $nameDay = date("D", strtotime($value));
        if ($nameDay == "Sat" || $nameDay == "Sun") {
            $fail("You can't choose a day that falls on a weekend");
        }
    }
}
