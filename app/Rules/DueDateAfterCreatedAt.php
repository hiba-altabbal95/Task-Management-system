<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DueDateAfterCreatedAt implements ValidationRule
{   protected $createdAt;

    public function __construct($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    

    public function passes($attribute, $value)
    {
        return $value > $this->createdAt;
    }

    public function message()
    { return 'The due date must be after the creation date.';
    }
}
