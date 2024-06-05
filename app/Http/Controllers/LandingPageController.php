<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class LandingPageController extends Controller
{
    function index() {
        $title = 'E-Commerce | Index';
        $sellers = User::with('store')->has('store')->whereHas('store', function($query) { $query->whereNotNull('address_id'); })->where('role', 'Seller')->inRandomOrder()->limit(6)->get();
        $products = Product::with('user.store')->has('user.store')->whereHas('user.store', function($query) { $query->whereNotNull('address_id'); })->inRandomOrder()->limit(8)->get();
        return view('landing-page.index', compact('title', 'sellers', 'products'));
    }

    function product(Product $product) {
        $title = 'E-Commerce | ' . $product->product_name;
        if(!$product->user->store->address_id) return  redirect('/')->withErrors(['error' => "Product doesn't have address!"]);
        return view('landing-page.detail', compact('title', 'product'));
    }

    function store(User $seller) {
        $title = 'E-Commerce | Store';
        $seller->with('store');
        if(!$seller->store->address_id) {
            return redirect('/')->withErrors(['error' => "Seller doesn't have address!"]);
        }
        $countProduct = $seller->product->count();
        $seller->setRelation('product', $seller->product()->paginate(9));
        return view('landing-page.store', compact('title', 'seller', 'countProduct'));
    }

    function products() {
        $title = 'E-Commerce | Products';
        $products = Product::with('user.store')->has('user.store')->whereHas('user.store', function($query) { $query->whereNotNull('address_id'); })->paginate(9);
        return view('landing-page.products', compact('title', 'products'));
    }

    function productSearch(Request $request) {
        $title = 'E-Commerce | Products';
        $products = Product::with('user.store')->has('user.store')->whereHas('user.store', function($query) { $query->whereNotNull('address_id'); })->whereAny([
            'product_name',
            'price',
        ], 'LIKE', '%'.$request->key.'%')->paginate(9);
        return view('landing-page.products', compact('title', 'products'));
    }
}
