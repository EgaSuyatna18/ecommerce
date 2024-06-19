<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Payment;
use Storage;

class ProductController extends Controller
{
    function product() {
        $title = 'Product Management';
        $products = Product::where('user_id', auth()->user()->id)->paginate(10);
        return view('dashboard.seller.product', compact('title', 'products'));
    }

    function productStore(Request $request) {
        $validated = $request->validate([
            'product_image' => 'required|mimes:jpg,jpeg,png|file|max:2048',
            'product_name' => 'required|min:5|max:25',
            'weight' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'description' => 'required|min:1|max:60000',
        ]);

        $validated['product_image'] = $request->file('product_image')->store('product-image');
        $validated['user_id'] = auth()->user()->id;

        Product::create($validated);

        return redirect('/product')->with('success', 'Product Added Successfully.');
    }

    function productDestroy(Product $product) {
        if($product->product_image !== 'assets/default/product.png') {
            Storage::delete($product->product_image);
        }
        $product->delete();
        return redirect('/product')->with('success', 'Product Deleted Successfully.');
    }

    function productUpdate(Request $request, Product $product) {
        $rules = [
            'product_name' => 'required|min:5|max:25',
            'weight' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'description' => 'required|min:1|max:60000',
        ];

        if($request->file('product_image')) {
            $rules['product_image'] = 'required|mimes:jpg,jpeg,png|file|max:2048';
        }

        $validated = $request->validate($rules);

        if($request->file('product_image')) {
            Storage::delete($product->product_image);
            $validated['product_image'] = $request->file('product_image')->store('product-image');
        }

        $product->update($validated);

        return redirect('/product')->with('success', 'Product updated successfully.');
    }

    function ordered() {
        $title = 'Ordered Report';
        $orders = Payment::with(['payment_detail.product', 'user'])
                            ->whereHas('payment_detail.product', function($query) {
                                $query->where('user_id', auth()->user()->id);
                            })
                            ->paginate(10);
        return view('dashboard.seller.orders', compact('title', 'orders'));
    }

    function orderedDetail(Payment $order) {
        $title = 'Ordered Detail Report';
        $order->with(['payment_detail.product'])->get();
        return view('dashboard.seller.order_detail', compact('title', 'order'));
    }
}
