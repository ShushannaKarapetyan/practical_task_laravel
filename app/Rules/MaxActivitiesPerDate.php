<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Activity;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class MaxActivitiesPerDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $activitiesCount = Activity::whereDate('date', $value)->count();

        if ($activitiesCount === 4) {
            $fail("Cannot update to this date. There are already 4 activities on this day.");
        }
    }

    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $value === 4;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'Cannot update to this date. There are already 4 activities on this day.';
    }
}
