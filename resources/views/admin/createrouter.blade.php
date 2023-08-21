@extends('admin.template.dashboard')
@section('content')

<div class="page-heading">
  <h3>Add Router</h3>
</div>
<div class="page-content">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <span>
          <a href="/admin/router" class="">Router List</a>
          / create
        </span>
      </div>
      <div class="card-body">
        <form action="/admin/router" method="post">
          @csrf
          <div class="form-floating mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="username" name="name" placeholder="name" value="{{ old('name') }}">
            <label for="name">Name</label>
            @error('name')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control @error('ip') is-invalid @enderror" id="floatingInput" placeholder="Ip" name="ip" value="{{ old('ip') }}">
            <label for="floatingInput">Ip Address</label>
            @error('ip')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="username" value="{{ old('username') }}">
            <label for="username">Username</label>
            @error('username')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-floating">
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
            @error('password')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <button class="btn btn-primary float-end my-5 px-4">Save</button>
        </form>
      </div>
    </div>

  </section>
</div>


@endsection