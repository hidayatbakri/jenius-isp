@extends('admin.template.dashboard')
@section('content')

<div class="page-heading">
  <h3>Dashboard</h3>
</div>
<div class="page-content">
  <section class="row">
    <div class="col-12 col-lg-9">
      <div class="row">
        <!-- <div class="col-6 col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body px-4 py-4-5">
              <div class="row">
                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                  <div class="stats-icon purple mb-2">
                    <i class="iconly-boldShow"></i>
                  </div>
                </div>
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-muted font-semibold">Profile Views</h6>
                  <h6 class="font-extrabold mb-0">112.000</h6>
                </div>
              </div>
            </div>
          </div>
        </div> -->
        <div class="col-6 col-md-6">
          <div class="card">
            <div class="card-body px-4 py-4-5">
              <div class="row">
                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                  <div class="stats-icon blue mb-2">
                    <i class="iconly-boldProfile"></i>
                  </div>
                </div>
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-muted font-semibold">Customer</h6>
                  <h6 class="font-extrabold mb-0">0</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-6">
          <div class="card">
            <div class="card-body px-4 py-4-5">
              <div class="row">
                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                  <div class="stats-icon green mb-2">
                    <i class="iconly-boldAdd-User"></i>
                  </div>
                </div>
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-muted font-semibold">Income</h6>
                  <h6 class="font-extrabold mb-0">IDR. 0</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-3">
      <div class="card">
        <div class="card-body py-4 px-4">
          <div class="d-flex align-items-center">
            <div class="avatar avatar-xl">
              <img src="/assets/images/faces/1.jpg" alt="Face 1">
            </div>
            <div class="ms-3 name">
              <h5 class="font-bold">{{ Auth::user()->name }}</h5>
              <h6 class="text-muted mb-0">{{ Auth::user()->level }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <livewire:realtime-data :router="$router" />
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Basic Info</h4>
            <table>
              <tr>
                <td width="130px">Name</td>
                <td>: </td>
                <td> {{ $router->name }}</td>
              </tr>
              <tr>
                <td width="130px">Ip Address</td>
                <td>: </td>
                <td> {{ $router->ip }}</td>
              </tr>
              <tr>
                <td width="130px">Username</td>
                <td>: </td>
                <td> {{ $router->username }}</td>
              </tr>
            </table>
            <a href="/admin/router/{{ $router->id }}/edit" class="btn btn-primary px-4 float-end my-3">Edit</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div class="result">

  @livewireScripts
  @stack('js')
</div>

@endsection