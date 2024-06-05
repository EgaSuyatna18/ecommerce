<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\seller\ProductController;
use App\Http\Controllers\seller\StoreController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\buyer\CartController;
use App\Http\Controllers\buyer\PaymentController;

route::get('/', [LandingPageController::class, 'index']);
route::get('/product/{product}', [LandingPageController::class, 'product']);
route::get('/store/{seller}', [LandingPageController::class, 'store']);
route::get('/products', [LandingPageController::class, 'products']);
route::post('/products', [LandingPageController::class, 'productSearch']);

route::get('/dashboard', [DashboardController::class, 'index']);

route::post('/webhook_midtrans', [PaymentController::class, 'webhookMidtrans']);

Route::middleware(['auth', 'isBuyer'])->group(function () {
    Route::middleware(['auth', 'isHasPayment'])->group(function () {
        Route::get('/cart', [CartController::class, 'cart']);
        Route::post('/cart', [CartController::class, 'addCart']);
        Route::delete('/cart/{cart}', [CartController::class, 'destroyCart']);
        Route::put('/cart/{cart}/{qty}', [CartController::class, 'editCart']);
    }); 
    
    Route::post('/payment', [PaymentController::class, 'paymentStore']);
    Route::post('/payment_placing/{payment}', [PaymentController::class, 'paymentPlacing']);
    Route::post('/get_midtrans_token', [PaymentController::class, 'getMidtransToken']);
    Route::get('/payment', [PaymentController::class, 'payment'])->middleware('isNotHasPayment');
    Route::post('/get_shipping/{destination}/{courier}', [PaymentController::class, 'getShipping']);
    Route::delete('/payment', [PaymentController::class, 'paymentDestroy']);
    Route::get('/transaction_history', [PaymentController::class, 'transactionHistory']);
    Route::get('/transaction_history_detail/{payment_id}', [PaymentController::class, 'transactionHistoryDetail']);
});

Route::middleware(['auth', 'isSeller'])->group(function () {
    Route::get('/store_setting', [StoreController::class, 'store_setting']);
    Route::post('/store_image/{store}', [StoreController::class, 'store_image']);
    Route::post('/store_info/{store}', [StoreController::class, 'store_info']);

    Route::get('/product', [ProductController::class, 'product']);
    Route::post('/product', [ProductController::class, 'productStore']);
    Route::delete('/product/{product}', [ProductController::class, 'productDestroy']);
    Route::put('/product/{product}', [ProductController::class, 'productUpdate']);
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin', [UserController::class, 'admin']);
    Route::post('/admin', [UserController::class, 'adminStore']);
    Route::delete('/admin/{admin}', [UserController::class, 'adminDestroy']);
    Route::put('/admin/{admin}', [UserController::class, 'adminUpdate']);

    Route::get('/seller', [UserController::class, 'seller']);
    Route::post('/seller', [UserController::class, 'sellerStore']);
    Route::delete('/seller/{seller}', [UserController::class, 'sellerDestroy']);
    Route::put('/seller/{seller}', [UserController::class, 'sellerUpdate']);

    Route::get('/buyer', [UserController::class, 'buyer']);
    Route::post('/buyer', [UserController::class, 'buyerStore']);
    Route::delete('/buyer/{buyer}', [UserController::class, 'buyerDestroy']);
    Route::put('/buyer/{buyer}', [UserController::class, 'buyerUpdate']);
});

Route::get('/logout', function (Request $request) {
    Auth::logout();
 
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
 
    return redirect('/');
});

route::get('/test/{order_id}', [PaymentController::class, 'getPaymentStatus']);

