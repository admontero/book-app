<?php

namespace App\Rules;

use App\Enums\CopyStatusEnum;
use App\Models\Copy;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CopyMustBeAvailable implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = Copy::where('id', $value)->where('status', CopyStatusEnum::DISPONIBLE)->where('is_loanable', 1)->exists();

        if (! $exists) {
            $fail('La copia seleccionada no está disponible');
        }
    }
}
