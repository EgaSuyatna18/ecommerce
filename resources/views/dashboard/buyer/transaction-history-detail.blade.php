@extends('layouts.dashboard.master')
@section('content')
<div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
        <h6 class="text-white text-capitalize ps-3">Transaction History Detail table</h6>
      </div>
      <a href="/transaction_history" class="btn btn-primary mt-3"><i class="material-icons">arrow_back_ios</i></a>
    </div>
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>No</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 w-25">Product Image</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Weight</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Price</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
              <th class="text-secondary opacity-7"></th>
            </tr>
          </thead>
          <tbody>
            @php
                $total = 0;
            @endphp
            @foreach ($paymentDetail as $pd)
            @php
                $total += $pd->qty * $pd->product->price;
            @endphp
                <tr>
                    <td><p class="ms-3">{{ $loop->index + 1 }}</p></td>
                    <td><img class="img-fluid w-25" src="{{ ($pd->product->product_image == 'assets/default/product.png') ? '/' : 'storage/'}}{{ $pd->product->product_image  }}" alt="errorIMG"></td>
                    <td>{{ $pd->product->product_name }}</td>
                    <td>{{ $pd->product->weight }}</td>
                    <td>Rp. {{ number_format($pd->product->price) }}</td>
                    <td>{{ $pd->qty }}</td>
                    <td>Rp. {{ number_format($pd->qty * $pd->product->price) }}</td>
                </tr>
            @endforeach
            <tr>
              <td colspan="5" align="center"><h3>Total</h3></td>
              <td align="center"><h3>Rp. {{ number_format($total) }}</h3></td>
            </tr>
          </tbody>
        </table>
        <div class="w-25 m-auto">
            {{ $paymentDetail->links() }}
        </div>
    </div>
    </div>
  </div>    
@endsection