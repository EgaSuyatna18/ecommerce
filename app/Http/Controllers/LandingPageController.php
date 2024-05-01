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
}
