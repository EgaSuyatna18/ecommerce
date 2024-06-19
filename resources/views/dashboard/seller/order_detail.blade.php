@extends('layouts.dashboard.master')
@section('content')
  <div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
        <h6 class="text-white text-capitalize ps-3">Ordered table</h6>
      </div>
    </div>
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>No</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 w-25">Product</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @php $total = 0; @endphp
            @foreach ($order->payment_detail as $pd)
            @php $total += $pd->product->price * $pd->qty @endphp
                <tr>
                    <td><p class="ms-3">{{ $loop->index + 1 }}</p></td>
                    <td>{{ $pd->product->product_name }}</td>
                    <td>{{ $pd->qty }}</td>
                    <td>Rp. {{ number_format($pd->product->price) }}</td>
                    <td>Rp. {{ number_format($pd->product->price * $pd->qty) }}</td>
                </tr>
            @endforeach
            <tr>
              <td colspan="4">Total</td>
              <td align="center">Rp. {{ number_format($total) }}</td>
            </tr>
          </tbody>
        </table>
    </div>
    </div>
  </div>

@endsection