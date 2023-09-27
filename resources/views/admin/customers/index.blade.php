@extends('admin.template.dashboard')
@section('container')

<div class="section-header">
  <h1>Pelanggan</h1>
</div>

<livewire:transaction-data />



@livewireScripts
@stack('js')
@endsection