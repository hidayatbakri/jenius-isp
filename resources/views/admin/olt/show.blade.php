@extends('admin.template.dashboard')
@section('container')

<div class="section-header">
  <h1>Olt</h1>
</div>


<div class="row">
  <div class="col-12 col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Daftar Alat Odc</h4>
      </div>
      <div class="card-body">
        <div class="list-link mb-4">
          <a type="button" class="btn btn-success me-3" href="/admin/tools">Menu Alat</a>
          <a href="/admin/tools/map" class="btn btn-primary">Lokasi Alat</a>
        </div>
        <div class="table-responsive table-invoice">
          <table class="table" id="dataTable2">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Alamat</th>
                <th>Port</th>
                <th>Map</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($odc as $row)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->address }}</td>
                <td>{{ count($row->odp) }}/{{ $row->port }}</td>
                <td>Buka <a target="_blank" href="https://google.com/maps/place/{{ $row->latitude }},{{ $row->longitude }}"><i class="fas fa-external-link-alt px-1"></i></a></td>
                <td>
                  <a href="/admin/odc/{{ $row->id }}" class="badge btn-primary">Detail</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
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
@if (@session('error'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: `{{ @session('error') }}`,
  })
</script>
@endif

@endsection