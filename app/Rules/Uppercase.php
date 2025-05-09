<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Uppercase implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //

    }
    public function __construct(){ }
    public function passes($attribute, $value){
        return strtoupper($value) === $value;
    }
    public function message() {
    return 'Thuộc tính :attribute phải là chữ hoa!';
    }

}
