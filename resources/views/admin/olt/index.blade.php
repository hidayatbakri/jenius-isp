@extends('admin.template.dashboard')
@section('container')

<div class="section-header">
  <h1>Olt</h1>
</div>

<div class="row">
  <div class="col-12 col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Data Olt</h4>
      </div>
      <div class="card-body">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Olt</button>

        <div class="table-responsive table-invoice" style="min-height: 620px !important;">
          <table class="table table-bordered" id="dataTable">
            <thead>
              <tr>
                <th>No</th>
                <th width="40%">Ip / Host</th>
                <th>Id Koneksi</th>
                <th>User</th>
                <th>Port</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($olt as $row)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $row['host'] }}</td>
                <td>{{ $row['id'] }}</td>
                <td>{{ $row['username'] }}</td>
                <td>{{ $row['port'] }}</td>
                <td class="{{ $row['host'] == $oltActive['host'] ? 'text-success' : 'text-danger' }}">{{ $row['host'] == $oltActive['host'] ? "Tersambung" : "Terputus" }}</td>
                <td>
                  <!-- Example single danger button -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                      Menu
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="/admin/olt/{{ $row['id'] }}" class="dropdown-item">Detail</a>
                      </li>
                      <li>
                        <a href="/admin/olt/{{ $row['id'] }}/edit" class="dropdown-item">Edit</a>
                      </li>
                      <li>
                        <a href="/admin/olt/disconnect" class="dropdown-item {{ $row['host'] == $oltActive['host'] ? '' : 'disabled'}}">Disconnect</a>
                      </li>
                      <li>
                        <form class="dropdown-item" style="display: block;" action="/admin/olt/setActive/{{ $row['id'] }}" method="post">
                          @csrf
                          @method('put')
                          <button type="submit" class="border-0 w-100 bg-transparent text-start" style="font-size: 14px;" {{ $row["host"] == $oltActive["host"] ? "disabled" : ""}}>Connect</button>
                        </form>
                      </li>
                      <li>
                        <form class="dropdown-item" style="display: block;" action="/admin/olt/{{ $row['id'] }}" method="post">
                          @csrf
                          @method('delete')
                          <button type="submit" style="font-size: 14px;" onclick="return confirm('Apakah anda ingin menghapus?')" class="text-start border-0 w-100 bg-transparent">Delete</button>
                        </form>
                      </li>
                    </ul>
                  </div>
                  <!-- <div class="d-flex">
                    <a href="/admin/olt/disconnect" class="btn btn-sm btn-warning me-1 {{ $row['host'] == $oltActive['host'] ? '' : 'disabled'}}">Disconnect</a>

                    <a href="/admin/olt/{{ $row['id'] }}/edit" class="btn btn-sm btn-secondary me-1">Edit</a>
                  </div> -->
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



<!-- modal tambah -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/admin/olt" method="post">
      @csrf
      @method('post')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Formulir</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="host">Ip/Host:</label>
            <input type="text" class="form-control @error('host') is-invalid @enderror" name="host" id="host" value="{{ old('host') }}">
            @error('host')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="username">User:</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ old('username') }}">
            @error('username')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="port">Port:</label>
            <input type="number" class="form-control @error('port') is-invalid @enderror" name="port" id="port" value="{{ old('port') }}">
            @error('port')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
            @error('password')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </form>
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