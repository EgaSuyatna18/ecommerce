<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\PaymentDetail;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    function paymentStore() {
        $payment_id = rand();
        $carts = Cart::where('user_id', auth()->user()->id)->get();

        if(!count($carts)) return redirect('/')->withErrors("You Doesn't Have Any Cart!");

        Payment::create([
            'id' => $payment_id,
            'user_id' => auth()->user()->id,
            'status' => 'pending'
        ]);
        foreach($carts as $cart) {
            PaymentDetail::create([
                'payment_id' => $payment_id,
                'product_id' => $cart->product_id,
                'qty' => $cart->qty
            ]);
            $cart->delete();
        }

        return redirect('/payment')->with('success', 'Please Finish Payment Before 24 Hours.');
    }

    function payment() {
        $title = 'Payment';
        $payment = Payment::with('payment_detail.product')->where('user_id', auth()->user()->id)->first();
        $cities = json_decode(self::getAllCity()->body())->rajaongkir->results;

        return view('landing-page.payment', compact('title', 'payment', 'cities'));
    }

    function getAllCity() {
        $response = Http::withHeaders([
            'key' => env('RO_KEY'),
        ])->get('https://api.rajaongkir.com/starter/city');

        return $response;
    }

    function getShipping($destination, $courier) {
        $destination = urldecode(str_replace(' ', '%20', $destination));
        $payment = Payment::with('payment_detail.product.user')->where('user_id', auth()->user()->id)->first();
        $response = Http::post('https://api.rajaongkir.com/starter/cost', [
            'key' => env('RO_KEY'),
            'origin' => $payment->payment_detail[0]->product->user->store->address_id,
            'destination' => $destination,
            'weight' => $payment->payment_detail[0]->product->weight,
            'courier' => $courier
        ]);
        return $response;
    }

    function paymentDestroy() {
        Payment::where('user_id', auth()->user()->id)->delete();
        return redirect('/')->with('success', 'Successfully Cancle Payment.');
    }
}
