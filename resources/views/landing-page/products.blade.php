@extends('layouts.landing-page.master')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Our Product</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">E-Commerce</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Products</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Product Start -->
            <div class="col-12">
                <div class="row pb-3">
                    @if ($products->count())
                        
                        @foreach ($products as $product)
                            
                        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="{{ ($product->product_image == 'assets/default/product.png') ? '/' : 'storage/'}}{{ $product->product_image  }}" alt="">
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

                    @else
                        <div class="text-center w-100">
                            <h1>Product Not Exists</h1>
                        </div>
                    @endif

                </div>
            </div>
            <!-- Shop Product End -->
            <div class="w-100">
                {{ $products->links() }}
            </div>
        </div>
    </div>
    <!-- Shop End -->
@endsection