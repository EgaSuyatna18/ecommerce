@extends('layouts.dashboard.master')
@section('content')
<div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
        <h6 class="text-white text-capitalize ps-3">Transaction History table</h6>
      </div>
    </div>
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>No</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 w-25">Transactin Code</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
              <th class="text-secondary opacity-7"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td><p class="ms-3">{{ $loop->index + 1 }}</p></td>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->address }}</td>
                    <td>{{ $payment->created_at }}</td>
                    <td>
                        <a href="/transaction_history_detail/{{ $payment->id }}" class="btn btn-info">Detail</a>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <div class="w-25 m-auto">
            {{ $payments->links() }}
        </div>
    </div>
    </div>
  </div>    
@endsection