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
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 w-25">Buyer</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Time</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
              <th class="text-secondary opacity-7"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td><p class="ms-3">{{ $loop->index + 1 }}</p></td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                      <a href="/ordered/{{ $order->id }}/detail" class="btn btn-info"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <div class="w-25 m-auto">
            {{ $orders->links() }}
        </div>
    </div>
    </div>
  </div>

@endsection