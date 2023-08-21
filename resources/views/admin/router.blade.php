@extends('admin.template.dashboard')
@section('content')

<div class="page-heading">
  <h3>Router List</h3>
</div>
<div class="page-content">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <a href="/admin/router/create" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add new router</a>
      </div>
      <div class="card-body" style="overflow-x: scroll;">
        <table class="table mt-5 table-hover table-striped" id="dataTable">
          <thead class="bg-primary">
            <tr>
              <th class="text-white" scope="col">No</th>
              <th class="text-white" scope="col">Router Name</th>
              <th class="text-white" scope="col">Ip Address</th>
              <th class="text-white" scope="col">Username</th>
              <th class="text-white" scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($routers as $router)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $router->name }}</td>
              <td>{{ $router->ip }}</td>
              <td>{{ $router->username }}</td>
              <td>
                <center>
                  <form action="/admin/router/{{ $router->id }}" method="post">
                    @csrf
                    @method('delete')
                    <a href="/admin/router/{{ $router->id }}" class="btn btn-success"><i class="bi bi-eye"></i></a>
                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                    <a href="/admin/router/{{ $router->id }}/edit" class="btn btn-info"><i class="bi bi-pencil"></i></a>
                  </form>
                </center>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </section>
</div>

@if (@session('success'))
<script>
  Swal.fire(
    'Good job!',
    `{{ @session('success') }}`,
    'success'
  )
</script>
@endif

@endsection