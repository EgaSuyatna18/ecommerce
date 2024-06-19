<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Rules\not_at_cart;
use App\Rules\same_store;

class CartController extends Controller
{
    function cart() {
        $title = 'My Cart';
        $carts = Cart::where('user_id', auth()->user()->id)->get();
        return view('landing-page.cart', compact('title', 'carts'));
    }

    function addCart(Request $request) {
        $validated = $request->validate([
            'qty' => 'required|numeric|min:1',
            'product_id' => ['required', new not_at_cart, new same_store]
        ]);

        $validated['user_id'] = auth()->user()->id;

        Cart::create($validated);

        return redirect('/cart')->with('success', 'Add To Cart Successfully.');
    }

    function destroyCart(Cart $cart) {
        $cart->delete();
        return redirect('/cart')->with('success', 'Cart Deleted Successfully.');
    }

    function editCart(Request $request, Cart $cart, $qty) {
        $cart->with('product');
        if($cart->product->stock < $qty) {
            $response = response()->json([
                'message' => 'Failed',
                'status' => 400,
                'max' => $cart->product->stock
            ]);
        }else {
            $response = response()->json([
                'message' => 'Success',
                'status' => 200,
            ]);

            $cart->update([
                'qty' => $qty
            ]);
        }
        return $response;
    }
}
