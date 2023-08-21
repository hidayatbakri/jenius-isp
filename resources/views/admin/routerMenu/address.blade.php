@extends('admin.template.dashboard')
@section('content')

<div class="page-heading">
  <h3>Address List</h3>
</div>
<div class="page-content">
  <section class="row">
    <div class="col-12 col-lg-10">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body px-5 py-4-5">
            </div>
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