@extends('layouts.dashboard.master')
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Product table</h6>
          </div>
          <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="material-icons">add</i>
          </button>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th>No</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 w-25">Product Image</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td><p class="ms-3">{{ $loop->index + 1 }}</p></td>
                        <td><img class="img-fluid w-25" src="{{ ($product->product_image == 'assets/default/product.png') ? '' : 'storage/'}}{{ $product->product_image  }}" alt="errorIMG"></td>
                        <td>{{ $product->product_name }}</td>
                        <td>Rp. {{ number_format($product->price) }}</td>
                        <td>
                          <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                            onclick="setData('{{ $product->id }}', '{{ $product->product_name }}', '{{ $product->price }}')">
                            <i class="material-icons">edit</i>
                          </button>
                          <form action="/product/{{ $product->id }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete Data {{ $product->product_name }} ?')"><i class="material-icons">delete</i></button>
                          </form>
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
            <div class="w-25 m-auto">
                {{ $products->links() }}
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addModalLabel">Add Modal</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/product" method="post" id="addForm" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label>Product Image</label>
            <input type="file" name="product_image" class="form-control border border-1" required>
          </div>
          <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="product_name" class="form-control border border-1 ps-2" required>
          </div>
          <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control border border-1 ps-2" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="addForm" class="btn btn-success">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Modal</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="editForm" enctype="multipart/form-data">
          @csrf
          @method('put')
          <div class="mb-3">
            <label>Product Image</label>
            <input type="file" name="product_image" class="form-control border border-1">
          </div>
          <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="product_name" id="editProductName" class="form-control border border-1 ps-2" required>
          </div>
          <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" id="editPrice" class="form-control border border-1 ps-2" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="editForm" class="btn btn-success">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>
  function setData(product_id, product_name, price) {
    editForm.action = '/product/' + product_id;
    editProductName.value = product_name;
    editPrice.value = price;
  }
</script>

@endsection