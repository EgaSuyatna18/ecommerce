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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="/dashboard">{{ auth()->user()->name }}</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($carts as $cart)
                            @php
                                $total += $cart->product->price * $cart->qty;
                            @endphp
                        <tr>
                            <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;">{{ $cart->product->product_name }}</td>
                            <td class="align-middle">Rp. {{ number_format($cart->product->price) }}</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" data-id={{ $cart->id }}>
                                        <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="number" min="1" onchange="editCart(this.value, {{ $cart->id }})" class="form-control form-control-sm bg-secondary text-center" value="{{ $cart->qty }}">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus" data-id={{ $cart->id }}>
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">Rp. {{ number_format($cart->qty * $cart->product->price) }}</td>
                            <td class="align-middle">
                                <form action="/cart/{{ $cart->id }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button>
                                </form>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">Rp. {{ number_format($total) }}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">$160</h5>
                        </div>
                        <form action="/payment" method="post">
                            @csrf
                            <button type="submit" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

    <script>
        function editCart(input, cart_id) {
            fetch('/cart/'+cart_id+'/' + input, {
                method: 'put',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // menguraikan respons menjadi objek JavaScript
            })
            .then(data => {
                // data yang diterima dari server
                console.log(data);
            })
            .catch(error => {
                // menangani kesalahan
                console.error('There was a problem with your fetch operation:', error);
            });
            }
    </script>
@endsection