@extends('admin.template.dashboard')
@section('container')


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/tools">Alat</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail alat</li>
  </ol>
</nav>

<div class="row">
  <div class="col-6 col-sm-6 col-lg-6">
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
</div>


@livewireScripts
@stack('js')
@endsection