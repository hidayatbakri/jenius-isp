@extends('admin.template.dashboard')
@section('container')

<div class="section-header">
  <h1>Pelanggan</h1>
</div>

<div class="row mt-3">
  <div class="col-12 col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Project Details</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive table-invoice">
          <livewire:get-onu />
        </div>
      </div>
    </div>
  </div>
</div>


@livewireScripts
@stack('js')
@endsection