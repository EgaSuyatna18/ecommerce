<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    function index() {
        $title = 'Dashboard | ' . strtoupper(auth()->user()->role);
        return view('dashboard.index', compact('title'));
    }

    function test() {
        $response = Http::withHeaders([
            'key' => env('RO_KEY'),
        ])->get('https://api.rajaongkir.com/starter/city');

        echo $response->body();
    }
}
