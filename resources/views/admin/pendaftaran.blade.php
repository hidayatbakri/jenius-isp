@extends('admin.template.dashboard')
@section('container')

<div class="section-header">
  <h1>Pelanggan</h1>
</div>
<div class="row">
  <div class="col-xl-3 col-lg-6">
    <div class="card">
      <div class="card-body card-type-3">
        <div class="row">
          <div class="col">
            <h6 class="text-muted mb-0">Client Expired</h6>
            <span class="fw-bold mb-0">{{ $clientExp }}</span>
          </div>
          <div class="col-auto">
            <div class="card-circle l-bg-orange text-white">
              <i class="fas fa-user"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6">
    <div class="card">
      <div class="card-body card-type-3">
        <div class="row">
          <div class="col">
            <h6 class="text-muted mb-0">Client PPOE</h6>
            <span class="fw-bold mb-0">{{ count($customers) }}</span>
          </div>
          <div class="col-auto">
            <div class="card-circle l-bg-cyan text-white">
              <i class="fas fa-user-tie"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="col-xl-3 col-lg-6">
    <div class="card">
      <div class="card-body card-type-3">
        <div class="row">
          <div class="col">
            <h6 class="text-muted mb-0">Onu Uncfg</h6>
            <span class="fw-bold mb-0">{{ count($customers) }}</span>
          </div>
          <div class="col-auto">
            <div class="card-circle l-bg-red text-white">
              <i class="fas fa-ethernet"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
</div>

<div class="row">
  <div class="col-12 col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Daftar Pelanggan</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive table-invoice">

          <livewire:transaction-data />

        </div>
      </div>
    </div>
  </div>
</div>


@livewireScripts
@stack('js')
@endsection