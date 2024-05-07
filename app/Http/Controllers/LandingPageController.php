<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class LandingPageController extends Controller
{
    function index() {
        $title = 'E-Commerce | Index';
        $sellers = User::where('role', 'Seller')->with('store')->inRandomOrder()->limit(6)->get();
        $products = Product::inRandomOrder()->limit(8)->get();
        return view('landing-page.index', compact('title', 'sellers', 'products'));
    }

    function product(Product $product) {
        $title = 'E-Commerce | ' . $product->product_name;
        $product->with('user.store');
        return view('landing-page.detail', compact('title', 'product'));
    }

    function store(User $seller) {
        $title = 'E-Commerce | Store';
        $seller->with('store');
        $countProduct = $seller->product->count();
        $seller->setRelation('product', $seller->product()->paginate(9));
        return view('landing-page.store', compact('title', 'seller', 'countProduct'));
    }

    function products() {
        $title = 'E-Commerce | Products';
        $products = Product::paginate(9);
        return view('landing-page.products', compact('title', 'products'));
    }

    function productSearch(Request $request) {
        $title = 'E-Commerce | Products';
        $products = Product::whereAny([
            'product_name',
            'price',
        ], 'LIKE', '%'.$request->key.'%')->paginate(9);
        return view('landing-page.products', compact('title', 'products'));
    }
}
