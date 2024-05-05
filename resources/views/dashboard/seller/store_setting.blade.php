@extends('layouts.dashboard.master')
@section('content')
    <link rel="stylesheet" href="assets/tomselect\tom-select.bootstrap5.min.css">
    <div class="container-fluid bg-white shadow shadow-lg rounded-3 p-4">
        <div class="row">
            <div class="col-2 offset-2 text-center">
                <img class="w-100" src="{{ ($store->store_image == 'assets/default/store.png') ? '' : 'storage/'}}{{ $store->store_image  }}" alt="errorIMG">
                <form action="/store_image/{{ auth()->user()->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="store_image" class="form-control border border-1 m-2">
                    <button type="submit" class="btn btn-success">Change Store Image</button>
                </form>
            </div>
            <div class="col-5 offset-1">
                <form action="/store_info/{{ auth()->user()->id }}" method="post">
                    @csrf
                    <input type="hidden" name="address_id" id="address_id">
                    <div class="mb-3">
                        <label>Store Name</label>
                        <input type="text" name="store_name" class="form-control border border-1 ps-2" value="{{ $store->store_name }}">
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <select id="cities" name="address" placeholder="Select a city..." autocomplete="off" onchange="setCityID(this)" required>
                            <option value="">Select a city...</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->city_name }}" {{ ($store->address == $city->city_name) ? 'selected' : '' }} data-addressid="{{ $city->city_id }}">{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-success">Edit Store Info</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/tomselect\tom-select.complete.min.js"></script>

    <script>
        new TomSelect("#cities",{
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });

        function setCityID(select) {
            address_id.value = select.options[select.selectedIndex].getAttribute('data-addressid');
        }
    </script>

@endsection