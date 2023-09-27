@extends('admin.template.dashboard')
@section('container')

<div class="section-header">
  <h1>Olt</h1>
</div>

<div class="row">
  <div class="col-12 col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Tambah Data Olt</h4>
      </div>
      <div class="card-body">
        <form action="/admin/olt/{{ $olt['id'] }}" method="post">
          @csrf
          @method('put')
          <div class="modal-body">
            <div class="form-group">
              <label for="host">Ip/Host:</label>
              <input type="text" class="form-control @error('host') is-invalid @enderror" name="host" id="host" value="{{ $olt['host'] }}">
              @error('host')
              <div id="validationServer04Feedback" class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="username">User:</label>
              <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ $olt['username'] }}">
              @error('username')
              <div id="validationServer04Feedback" class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="port">Port:</label>
              <input type="number" class="form-control @error('port') is-invalid @enderror" name="port" id="port" value="{{ $olt['port']}}">
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
          <div class="d-flex justify-content-end">
            <a href="/admin/olt" class="btn btn-secondary me-3">Kembali</a>
            <button class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection