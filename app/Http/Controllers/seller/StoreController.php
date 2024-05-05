<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;
use Storage;
use Illuminate\Support\Facades\Http;

class StoreController extends Controller
{
    function store_setting() {
        $title = 'Store Setting';
        $store = Store::where('user_id', auth()->user()->id)->first();
        $cities = json_decode(self::getAllCity()->body())->rajaongkir->results;

        if(!$store) {
            $store = Store::create([
                'user_id' => auth()->user()->id,
                'store_image' => 'assets/default/store.png',
                'store_name' => 'Default Store ' . rand(100000, 999999),
                'address' => null,
            ]);
        }

        return view('dashboard.seller.store_setting', compact('title', 'store', 'cities'));
    }

    function store_image(Request $request, Store $store) {
        $validated = $request->validate([
            'store_image' => 'required|mimes:jpg,jpeg,png|file|max:2048',
        ]);

        if($store->store_image !== 'assets/default/store.png') {
            Storage::delete($store->store_image);
        }

        $validated['store_image'] = $request->file('store_image')->store('store-image');

        $store->update($validated);

        return redirect('/store_setting')->with('success', 'Store Image Edited Successfully.');
    }

    function getAllCity() {
        $response = Http::withHeaders([
            'key' => env('RO_KEY'),
        ])->get('https://api.rajaongkir.com/starter/city');

        return $response;
    }

    function store_info(Request $request, Store $store) {
        $validated = $request->validate([
            'store_name' => 'required|min:6|max:25',
            'address_id' => 'required',
            'address' => 'required'
        ]);

        $store->update($validated);

        return redirect('/store_setting')->with('success', 'Store info edited successfully.');
    }
}
