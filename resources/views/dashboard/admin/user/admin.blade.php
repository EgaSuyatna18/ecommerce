@extends('layouts.dashboard.master')
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Admin table</h6>
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
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Join Date</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($admins as $admin)
                    <tr>
                        <td><p class="ms-3">{{ $loop->index + 1 }}</p></td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">{{ $admin->name }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ $admin->email }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <td>
                        <span class="text-secondary text-xs font-weight-bold">{{ $admin->created_at }}</span>
                        </td>
                        <td class="align-middle">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                              onclick="setData('{{ $admin->id }}', '{{ $admin->name }}', '{{ $admin->email }}')">
                              <i class="material-icons">edit</i>
                            </button>
                            <form action="/admin/{{ $admin->id }}" method="post" class="d-inline">
                              @csrf
                              @method('delete')
                              <button type="submit" class="btn btn-danger" onclick="return confirm('Delete Data {{ $admin->name }} ?')"><i class="material-icons">delete</i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
            <div class="w-25 m-auto">
                {{ $admins->links() }}
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
        <form action="/admin" method="post" id="addForm">
          @csrf
          <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control border border-1 ps-2" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control border border-1 ps-2" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control border border-1 ps-2" required>
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
        <form method="post" id="editForm">
          @csrf
          @method('put')
          <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" id="editName" class="form-control border border-1 ps-2" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" id="editEmail" class="form-control border border-1 ps-2" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control border border-1 ps-2">
            <div class="form-text" id="basic-addon4">Leave empty if there's no change.</div>
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
  function setData(admin_id, name, email) {
    editForm.action = '/admin/' + admin_id;
    editName.value = name;
    editEmail.value = email;
  }
</script>

@endsection