@extends('admin.template.dashboard')
@section('container')


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/tools">Alat</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail alat</li>
  </ol>
</nav>

<div class="row">
  <div class="col-5 col-sm-5 col-lg-5">
    <div class="card">
      <div class="card-header">
        <h4>Detail Alat</h4>
      </div>
      <div class="card-body">
        <img src="{{ asset('storage/' . $tool->foto) }}" style="max-width: 300px; object-fit: cover;" class="rounded">
        <ul class="list-group list-group-flush mt-3">
          <li class="list-group-item"><b>Nama</b> : {{ $tool->name }}</li>
          <li class="list-group-item"><b>Head</b> : {{ $tool->head }}</li>
          <li class="list-group-item"><b>Address</b> : {{ $tool->address }}</li>
          @if(isset($tool->odc_id))
          <li class="list-group-item"><b>Odc (Connect to)</b> : {{ $tool->odc->name }}</li>
          @endif
          <li class="list-group-item"><b>Description</b> : {{ $tool->description }}</li>
          <li class="list-group-item"><b>Map</b> : <td>Buka <a target="_blank" href="https://google.com/maps/place/{{ $tool->latitude }},{{ $tool->longitude }}"><i class="fas fa-external-link-alt px-1"></i></a></td>
          </li>
        </ul>
        <div class="d-flex justify-content-end mt-3">
          <a href="/admin/tools" class="btn btn-primary">Kembali</a>
        </div>
      </div>
    </div>
  </div>
  @if(isset($tool->odp))
  <div class="col-7 col-sm-7 col-lg-7">
    <div class="card">
      <div class="card-header">
        <h4>Alat Odp</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive table-invoice">
          <table class="table" id="dataTable">
            <table class="table" id="dataTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Alat</th>
                  <th>Alamat</th>
                  <th>Map</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($tool->odp as $rodp)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $rodp->name }}</td>
                  <td>{{ $rodp->address }}</td>
                  <td>Buka <a target="_blank" href="https://google.com/maps/place/{{ $rodp->latitude }},{{ $rodp->longitude }}"><i class="fas fa-external-link-alt px-1"></i></a></td>
                  <td>
                    <form action="/admin/tools/{{ $rodp->id }}" method="post">
                      @csrf
                      @method('delete')
                      <a href="/admin/odp/{{ $rodp->id }}" class="badge btn-primary my-2">Detail</a>
                      <button class="badge btn-danger" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
  @endif
  @if(isset($customers))
  <div class="col-7 col-sm-7 col-lg-7">
    <div class="card">
      <div class="card-header">
        <h4>Alat Odp</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive table-invoice">
          <table class="table" id="dataTable">
            <table class="table" id="dataTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Alat</th>
                  <th>Alamat</th>
                  <th>Map</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($customers as $customer)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $customer->name }}</td>
                  <td>{{ $customer->address }}</td>
                  <td>Buka <a target="_blank" href="https://google.com/maps/place/{{ $customer->latitude }},{{ $customer->longitude }}"><i class="fas fa-external-link-alt px-1"></i></a></td>
                  <td>
                    <form action="/admin/tools/{{ $customer->id }}" method="post">
                      @csrf
                      @method('delete')
                      <a href="/admin/customers/{{ $customer->id }}" class="badge btn-primary my-2">Detail</a>
                      <!-- <button class="badge btn-danger" onclick="return confirm('Apakah anda yakin?')">Hapus</button> -->
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>


@livewireScripts
@stack('js')
@endsection