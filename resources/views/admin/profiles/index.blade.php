@extends('admin.template.dashboard')
@section('container')


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/tools">Settings</a></li>
    <li class="breadcrumb-item active" aria-current="page">Profile</li>
  </ol>
</nav>

<div class="row">
  <div class="col-6 col-sm-12 col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4>Profile</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive table-invoice">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><b>Nama</b> : {{ Auth::user()->name }}</li>
            <li class="list-group-item"><b>Email</b> : {{ Auth::user()->email }}</li>
          </ul>
          <div class="d-flex justify-content-end">
            <a href="/admin" class="btn btn-secondary mt-5">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-sm-12 col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4>Ubah Profile</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive table-invoice">
          <form action="/admin/profile/{{Auth::user()->id}}" method="post">
            @csrf
            @method('put')
            <div class="form-group">
              <label for="name">Nama :</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}">
              @error('name')
              <div id="validationServer04Feedback" class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="password">Password :</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
              @error('password')
              <div id="validationServer04Feedback" class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
            </div>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary mt-5">Simpan</button>
            </div>
          </form>
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

@livewireScripts
@stack('js')
@endsection