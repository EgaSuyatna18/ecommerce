<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use App\Rules\alpha_space;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    function paymentStore() {
        $payment_id = rand();
        $carts = Cart::where('user_id', auth()->user()->id)->get();

        if(!count($carts)) return redirect('/')->withErrors("You Doesn't Have Any Cart!");

        DB::beginTransaction();
        foreach($carts as $cart) {
                $product = Product::where('id', $cart->product_id)->first();
                if($product->stock < $cart->qty) {
                    DB::rollback();
                    return redirect('/')->withErrors(['error' => 'Something unknown happen to your order.']);
                }
                $product->decrement('stock', $cart->qty);
        }
        DB::commit();

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
        $payment = Payment::with('payment_detail.product')->where('user_id', auth()->user()->id)->where('status', 'pending')->first();
        $cities = json_decode(self::getAllCity()->body())->rajaongkir->results;
        // if($payment->midtrans_token) {
        //     $paymentStatus = self::getPaymentStatus($payment->id);
        //     if($paymentStatus && $paymentStatus == 'expire') {
        //         $payment->delete();
        //         return redirect('/')->withErrors(['error' => 'Transaction expired and has been deleted.']);
        //     }else if(!$paymentStatus) {
        //         return view('landing-page.payment-exists', ['midtrans_token' => $payment->midtrans_token]);
        //     }
        // }

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
        $payment = Payment::with('payment_detail.product.user')->where('user_id', auth()->user()->id)->where('status', 'pending')->first();
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
        Payment::where('user_id', auth()->user()->id)->where('status', 'pending')->delete();
        return redirect('/')->with('success', 'Successfully Cancle Payment.');
    }

    function getMidtransToken(Request $request) {
        $shipping = self::getShipping($request->input('destination'), $request->input('courier'));
        $shippingPrice = 0;

        foreach($shipping['rajaongkir']['results'][0]['costs'] as $ship) {
            if($ship['service'] == $request->input('method')) {
                $shippingPrice = $ship['cost'][0]['value'];
                break;
            }
        }

        $payment = Payment::with('payment_detail.product')->where('user_id', auth()->user()->id)->where('status', 'pending')->first();
        $total = $shippingPrice;
        foreach($payment->payment_detail as $pd) {
            $total += $pd->qty * $pd->product->price;
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $payment->id,
                'gross_amount' => $total,
            ),
            'customer_details' => array(
                'full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'destination' => $request->input('destination')
            ),
        );

        $token = \Midtrans\Snap::getSnapToken($params);

        $payment->update([
            'midtrans_token' => $token,
            'address_id' => $request->input('destination'),
            'address' => $request->input('address')
        ]);

        return response()->json(['token' => $token]);
    }

    function webhookMidtrans(Request $request) {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key) {
            Payment::where('id', $request->order_id)->update(['status' => 'finished']);
        }
    }

    function transactionHistory() {
        $title = 'My Transaction History';
        $payments = Payment::where('user_id', auth()->user()->id)->where('status', 'finished')->paginate(5);
        return view('dashboard.buyer.transaction-history', compact('title', 'payments'));
    }

    function transactionHistoryDetail($payment_id) {
        $title = 'My Transaction History Detail';
        $paymentDetail = PaymentDetail::with('product')->where('payment_id', $payment_id)->paginate(5);
        $transferReceipt = Payment::where('id', $payment_id)->first()->transfer_receipt;
        return view('dashboard.buyer.transaction-history-detail', compact('title', 'paymentDetail', 'transferReceipt'));
    }

    function getPaymentStatus($order_id) {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode(env('MIDTRANS_SERVER_KEY') . ':'),
        ])->get("https://api.sandbox.midtrans.com/v2/$order_id/status");

        if ($response->json()['status_code'] == '404') {
            return false;
        } else {
            return $response->json()['transaction_status'];
        }
    }

    function paymentPlacing(Request $request, Payment $payment) {
        $data = [
            'address' => $request->input('address'),
            'address_id' => $request->input('address_id'),
            'method' => $request->input('method'),
            'status' => 'finished'
        ];

        if($request->file('transfer_receipt')) {
            $data['transfer_receipt'] = $request->file('transfer_receipt')->store('transfer-receipt');
        }

        $payment->update($data);

        return redirect('/')->with('success', 'Payment Finished.');
    }
}
