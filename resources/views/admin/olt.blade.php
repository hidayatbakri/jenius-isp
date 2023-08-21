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

        <div class="table-responsive table-invoice">
          <table class="table" id="dataTable">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Ip / Host</th>
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
                <td>{{ $row->name }}</td>
                <td>{{ $row->type }}</td>
                <td>{{ $row->host }}</td>
                <td>{{ $row->user }}</td>
                <td>{{ $row->port }}</td>
                <td class="{{ $row->status ? 'text-success' : '' }}">{{ $row->status ? 'Tersambung' : 'Terputus' }}</td>
                <td>
                  <div class="d-flex">

                    <form class="d-flex" action="/admin/olt/{{ $row->id }}" method="post">
                      @csrf
                      @method('delete')
                      <button type="submit" onclick="return confirm('Apakah anda ingin menghapus?')" class="btn btn-sm btn-danger me-1">Delete</button>
                      <button type="button" class="btn btn-sm btn-secondary me-1" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                    </form>
                    <form action="/admin/olt/setActive/{{ $row->id }}" method="post">
                      @csrf
                      @method('put')
                      <button type="submit" class="btn btn-sm btn-primary" {{ $row->status ? 'disabled' : '' }}>Connect</button>
                    </form>
                  </div>
                </td>
              </tr>
              <!-- modal edit -->
              <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form action="/admin/olt/{{ $row->id }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="name">Name:</label>
                          <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $row->name }}">
                          @error('name')
                          <div id="validationServer04Feedback" class="invalid-feedback">
                            {{$message}}
                          </div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="type">Type:</label>
                          <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" id="type" value="{{ $row->type }}">
                          @error('type')
                          <div id="validationServer04Feedback" class="invalid-feedback">
                            {{$message}}
                          </div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="host">Ip/Host:</label>
                          <input type="text" class="form-control @error('host') is-invalid @enderror" name="host" id="host" value="{{ $row->host }}">
                          @error('host')
                          <div id="validationServer04Feedback" class="invalid-feedback">
                            {{$message}}
                          </div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="user">User:</label>
                          <input type="text" class="form-control @error('user') is-invalid @enderror" name="user" id="user" value="{{ $row->user }}">
                          @error('user')
                          <div id="validationServer04Feedback" class="invalid-feedback">
                            {{$message}}
                          </div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="port">Port:</label>
                          <input type="number" class="form-control @error('port') is-invalid @enderror" name="port" id="port" value="{{ $row->port}}">
                          @error('port')
                          <div id="validationServer04Feedback" class="invalid-feedback">
                            {{$message}}
                          </div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="password">Password:</label>
                          <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" minlength="8" id="password">
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
            <label for="name">Name:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
            @error('name')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" id="type" value="{{ old('type') }}">
            @error('type')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
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
            <label for="user">User:</label>
            <input type="text" class="form-control @error('user') is-invalid @enderror" name="user" id="user" value="{{ old('user') }}">
            @error('user')
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

@endsection