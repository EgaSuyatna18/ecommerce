@extends('layouts.landing-page.master')
@section('content')
    <script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    @if (isset($payment->midtrans_token))
        <div id="snap-container text-center"></div>
        <script>
            window.snap.embed('{{ $payment->midtrans_token }}', {
                embedId: 'snap-container'
            });
        </script>
    @else
        <link rel="stylesheet" href="assets/tomselect\tom-select.bootstrap5.min.css">
        <!-- Page Header Start -->
        <div class="container-fluid bg-secondary mb-5">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
                <h1 class="font-weight-semi-bold text-uppercase mb-3">Payment</h1>
                <div class="d-inline-flex">
                    <p class="m-0"><a href="/dashboard">{{ auth()->user()->name }}</a></p>
                    <p class="m-0 px-2">-</p>
                    <p class="m-0">Payment</p>
                </div>
            </div>
        </div>
        <!-- Page Header End -->


        <!-- Checkout Start -->
        <div class="container-fluid pt-5">
            <div class="row px-xl-5">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Full Name</label>
                                <input class="form-control" value="{{ auth()->user()->name }}" id="full_name" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" value="{{ auth()->user()->email }}" id="email" type="email" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address</label>
                                <select id="cities" name="address" onchange="refreshShipping()" class="custom-select border border-1" placeholder="Select a city..." autocomplete="off" required>
                                    <option value="">Select a city...</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->city_id }}">{{ $city->city_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-4">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-medium mb-3">Products</h5>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($payment->payment_detail as $pd)
                            @php
                                $total += $pd->product->price;
                            @endphp
                                
                                <div class="d-flex justify-content-between">
                                    <p>{{ $pd->product->product_name }}</p>
                                    <p>Rp. {{ number_format($pd->product->price) }}</p>
                                </div>

                            @endforeach
                            <hr class="my-0">
                            <div class="card-body" id="courier">
                                <div class="form-group" id="eventPos">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="courier" id="pos">
                                        <label class="custom-control-label" for="pos">POS Indonesia</label>
                                    </div>
                                </div>
                                <div class="form-group" id="eventJne">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="courier" id="jne">
                                        <label class="custom-control-label" for="jne">Jalur Nugraha Ekakurir (JNE)</label>
                                    </div>
                                </div>
                                <div class="form-group" id="eventTiki">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="courier" id="tiki">
                                        <label class="custom-control-label" for="tiki">Citra Van Titipan Kilat (TIKI)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="methode">
                                {{-- js fill --}}
                            </div>
                            <hr class="mt-0">
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">Subtotal</h6>
                                <h6 class="font-weight-medium">Rp {{ number_format($total) }}</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium" id="shippingTag">Rp. 0</h6>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold">Total</h5>
                                <h5 class="font-weight-bold" id="totalTag">Rp. 0</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Payment</h4>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" id="pay-button">Place Order</button>
                            <form action="/payment" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-lg btn-block btn-danger font-weight-bold my-3 py-3">Cancel Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Checkout End -->

        <script src="assets/tomselect/tom-select.complete.min.js"></script>

        <script>
            new TomSelect("#cities",{
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('courier').addEventListener('click', function(event) {
                    if (event.target.matches('input[type="radio"]')) {
                        if(cities.value == '') {
                            event.preventDefault();
                            alert('Please Choose Address First!');
                        }
                        setShipping(event.target.id);
                    }
                });
            });

            function setShipping(courier) {
                if(cities.value == '') return;
                fetch('/get_shipping/' + cities.value + '/' + courier, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    setShippingPrice(0);
                    methode.innerHTML = '<hr class="mt-0">';
                    data.rajaongkir.results[0]['costs'].forEach(function(cost) {
                        methode.innerHTML += `
                            <div class="form-group" onclick="setShippingPrice(${cost['cost'][0]['value']})">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="method" id="${cost['service']}">
                                    <label class="custom-control-label" for="${cost['service']}">
                                        ${cost['service']}</br>
                                        Description: ${cost['description']}</br>
                                        Cost: Rp. ${cost['cost'][0]['value'].toLocaleString('id')}</br>
                                        Estimation: ${cost['cost'][0]['etd']} Day</br>
                                    </label>
                                </div>
                            </div>
                        `;
                    });
                    
                })
                .catch(error => {
                    console.error('There was a problem with your fetch operation:', error);
                });
            }

            function setShippingPrice(shipping) {
                let total = {{ $total }};
                shippingTag.innerHTML = 'Rp. ' + shipping.toLocaleString('id');
                total += shipping;
                totalTag.innerHTML = 'Rp. ' + total.toLocaleString('id');
            }

            function refreshShipping() {
                methode.innerHTML = '';
                setShippingPrice(0);
                pos.checked = false;
                jne.checked = false;
                tiki.checked = false;
            }

            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function() {
                const selectedCourier = document.querySelector('input[name="courier"]:checked');
                const selectedMethod = document.querySelector('input[name="method"]:checked');
                if(full_name.value == '') {
                    alert('Please Enter Full Name!');
                    return;
                }else if(email.value == '') {
                    alert('Please Enter Email!');
                    return;
                }else if(selectedCourier == null) {
                    alert('Please Choose Courier!');
                    return;
                }else if(selectedMethod == null) {
                    alert('Please Choose Sending Method!')
                    return;
                }

                let address = cities.options[cities.selectedIndex].text;

                fetch('/get_midtrans_token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        full_name: full_name.value,
                        email: email.value,
                        destination: cities.value,
                        address: address,
                        courier: selectedCourier.getAttribute('id'),
                        method: selectedMethod.getAttribute('id') 
                    })
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Request Failed!');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        window.snap.pay(data.token);
                    })
                    .catch(error => {
                        console.error('Error Occured:', error);
                    });
            });
        </script>
    @endif

    
@endsection