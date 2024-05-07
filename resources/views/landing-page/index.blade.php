@extends('layouts.landing-page.master')
@section('content')
<div id="header-carousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" style="height: 410px;">
            <img class="img-fluid" src="assets/landing-page/img/carousel-1.jpg" alt="Image">
            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                <div class="p-3" style="max-width: 700px;">
                    <h4 class="text-light text-uppercase font-weight-medium mb-3">E-Commerce</h4>
                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Buy Anything you Need.</h3>
                    <a href="/products" class="btn btn-light py-2 px-3">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="carousel-item" style="height: 410px;">
            <img class="img-fluid" src="assets/landing-page/img/carousel-2.jpg" alt="Image">
            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                <div class="p-3" style="max-width: 700px;">
                    <h4 class="text-light text-uppercase font-weight-medium mb-3">E-Commerce</h4>
                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Buy Anything You Want.</h3>
                    <a href="/products" class="btn btn-light py-2 px-3">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
        <div class="btn btn-dark" style="width: 45px; height: 45px;">
            <span class="carousel-control-prev-icon mb-n2"></span>
        </div>
    </a>
    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
        <div class="btn btn-dark" style="width: 45px; height: 45px;">
            <span class="carousel-control-next-icon mb-n2"></span>
        </div>
    </a>
</div>
<!-- Navbar End -->


<!-- Featured Start -->
<div class="container-fluid pt-5">
<div class="row px-xl-5 pb-3">
<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
<div class="d-flex align-items-center border mb-4" style="padding: 30px;">
    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
<div class="d-flex align-items-center border mb-4" style="padding: 30px;">
    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
<div class="d-flex align-items-center border mb-4" style="padding: 30px;">
    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
<div class="d-flex align-items-center border mb-4" style="padding: 30px;">
    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
</div>
</div>
</div>
</div>
<!-- Featured End -->


<!-- Categories Start -->
<div class="container-fluid pt-5">
<div class="text-center mb-4">
<h2 class="section-title px-5"><span class="px-2">Store</span></h2>
</div>
<div class="row px-xl-5 pb-3">
@foreach ($sellers as $seller)

<div class="col-lg-4 col-md-6 pb-1">
    <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
        <p class="text-right">15 Products</p>
        <a href="/store/{{ $seller->id }}" class="cat-img position-relative overflow-hidden mb-3">
            <img class="img-fluid" src="{{ ($seller->store->store_image == 'assets/default/store.png') ? '' : 'storage/'}}{{ $seller->store->store_image  }}" alt="errorIMG">
        </a>
        <h5 class="font-weight-semi-bold m-0">{{ $seller->store->store_name }}</h5>
    </div>
</div>

@endforeach
</div>
</div>
<!-- Categories End -->

<!-- Products Start -->
<div class="container-fluid pt-5">
<div class="text-center mb-4">
<h2 class="section-title px-5"><span class="px-2">Product</span></h2>
</div>
<div class="row px-xl-5 pb-3">
@foreach ($products as $product)

<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
    <div class="card product-item border-0 mb-4">
        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
            <img class="img-fluid w-100" src="{{ ($product->product_image == 'assets/default/product.png') ? '' : 'storage/'}}{{ $product->product_image  }}" alt="errorIMG">
        </div>
        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
            <h6 class="text-truncate mb-3">{{ $product->product_name }}</h6>
            <div class="d-flex justify-content-center">
                <h6>Rp {{ number_format($product->price) }}</h6><h6 class="text-muted ml-2">{{ $product->weight }} Kg</h6>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between bg-light border">
            <a href="/product/{{ $product->id }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
            <a href="/product/{{ $product->id }}" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
        </div>
    </div>
</div>

@endforeach
</div>
</div>
@endsection