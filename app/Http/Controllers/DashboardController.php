<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Product;

class DashboardController extends Controller
{
    function index() {

        if(auth()->user()->role == 'Seller' && !auth()->user()->store) return redirect('/store_setting')->with('success', 'Successfully registered, please enter store detail.');

        $title = 'Dashboard | ' . strtoupper(auth()->user()->role);
        $admin = User::where('role', 'Admin')->count();
        $seller = User::where('role', 'Seller')->count();
        $buyer = User::where('role', 'Buyer')->count();
        $product = Product::count();
        return view('dashboard.index', compact('title', 'admin', 'seller', 'buyer', 'product'));
    }
}
