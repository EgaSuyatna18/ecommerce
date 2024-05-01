<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Cart;

class not_at_cart implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(Cart::where([
            'user_id' => auth()->user()->id,
            'product_id' => $value
        ])->exists()) $fail('The :attribute already exists in cart!');
    }
}
