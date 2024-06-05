@extends('layouts.landing-page.master')
@section('content')
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
 <!-- Page Header Start -->
 <div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="/store/{{ $product->user->store->id }}">{{ $product->user->store->store_name }}</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">{{ $product->product_name }}</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Shop Detail Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border">
                    <div class="carousel-item active">
                        <img class="img-fluid w-100 h-100" src="/{{ ($product->product_image == 'assets/default/product.png') ? '' : 'storage/'}}{{ $product->product_image  }}" alt="errorIMG">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold">{{ $product->product_name }}</h3>
            <h3 class="font-weight-semi-bold mb-4">Rp. {{ number_format($product->price) }}</h3>
            <h3 class="font-weight-semi-bold mb-4">{{ $product->weight }} Kg</h3>
            <p>{{ $product->description }}</p>
            <div class="d-flex align-items-center mb-4 pt-2">
                <div class="input-group quantity mr-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-minus" >
                        <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="number" min="1" name="qty" class="form-control bg-secondary text-center" value="1" form="addCartForm">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <form action="/cart" method="post" id="addCartForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->
@endsection