<?php 
use App\Models\Cart;

if (! function_exists('countCart')) {
    function countCart() {
        return Cart::where('user_id', auth()->user()->id)->count();
    }
}