<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Rules\alpha_space;
use App\Rules\custom_password;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function admin() {
        $title = 'Admin Management';
        $admins = User::where('role', 'admin')->paginate(10);
        return view('dashboard.admin.user.admin', compact('title', 'admins'));
    }

    function adminStore(Request $request) {
        $validated = $request->validate([
            'name' => ['required', new alpha_space],
            'email' => 'email:rfc,dns',
            'password' => ['required', new custom_password]
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect('/admin')->with('success', 'Admin Added Successfully.');
    }

    function adminDestroy(User $admin) {
        $admin->delete();
        return redirect('/admin')->with('success', 'Admin Deleted Successfully.');
    }

    function adminUpdate(Request $request, User $admin) {
        $rules = [
            'name' => ['required', new alpha_space],
            'email' => 'email:rfc,dns',
        ];

        if($request->input('password')) {
            $rules['password'] = ['required', new custom_password];
        }

        $validated = $request->validate($rules);

        if($request->input('password')) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $admin->update($validated);

        return redirect('/admin')->with('success', 'Admin updated successfully.');
    }

    function seller() {
        $title = 'Seller Management';
        $sellers = User::where('role', 'seller')->paginate(10);
        return view('dashboard.admin.user.seller', compact('title', 'sellers'));
    }

    function sellerStore(Request $request) {
        $validated = $request->validate([
            'name' => ['required', new alpha_space],
            'email' => 'email:rfc,dns',
            'password' => ['required', new custom_password]
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'Seller';

        User::create($validated);

        return redirect('/seller')->with('success', 'Seller Added Successfully.');
    }

    function sellerDestroy(User $seller) {
        $seller->delete();
        return redirect('/seller')->with('success', 'Seller Deleted Successfully.');
    }

    function sellerUpdate(Request $request, User $seller) {
        $rules = [
            'name' => ['required', new alpha_space],
            'email' => 'email:rfc,dns',
        ];

        if($request->input('password')) {
            $rules['password'] = ['required', new custom_password];
        }

        $validated = $request->validate($rules);

        if($request->input('password')) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $seller->update($validated);

        return redirect('/seller')->with('success', 'Seller updated successfully.');
    }

    function buyer() {
        $title = 'Buyer Management';
        $buyers = User::where('role', 'buyer')->paginate(10);
        return view('dashboard.admin.user.buyer', compact('title', 'buyers'));
    }

    function buyerStore(Request $request) {
        $validated = $request->validate([
            'name' => ['required', new alpha_space],
            'email' => 'email:rfc,dns',
            'password' => ['required', new custom_password]
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'Buyer';

        User::create($validated);

        return redirect('/buyer')->with('success', 'Buyer Added Successfully.');
    }

    function buyerDestroy(User $buyer) {
        $buyer->delete();
        return redirect('/buyer')->with('success', 'Buyer Deleted Successfully.');
    }

    function buyerUpdate(Request $request, User $buyer) {
        $rules = [
            'name' => ['required', new alpha_space],
            'email' => 'email:rfc,dns',
        ];

        if($request->input('password')) {
            $rules['password'] = ['required', new custom_password];
        }

        $validated = $request->validate($rules);

        if($request->input('password')) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $buyer->update($validated);

        return redirect('/buyer')->with('success', 'Buyer updated successfully.');
    }
}
