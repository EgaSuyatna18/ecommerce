<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Cart;
use App\Models\Product;

class same_store implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $sellerID = Cart::first()->product->user->id;
        $newSellerID = Product::with('user')->where('id', $value)->first()->user->id;
        if($sellerID != $newSellerID) {
            $fail('Place orders one by one store');
        }
    }
}
