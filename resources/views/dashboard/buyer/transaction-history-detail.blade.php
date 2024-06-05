@extends('layouts.dashboard.master')
@section('content')
    <div class="card my-4">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
          <h6 class="text-white text-capitalize ps-3">Transaction History Detail table</h6>
        </div>
        <a href="/transaction_history" class="btn btn-primary mt-3"><i class="material-icons">arrow_back_ios</i></a>
        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="material-icons">print</i></button>
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
  </div>

  <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="/storage/{{ $transferReceipt }}" alt="This Transaction Not Using Transfer Receipt" class="img-fluid w-100">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>

@endsection