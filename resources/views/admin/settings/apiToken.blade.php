@extends('admin.template.dashboard')
@section('container')

<div class="section-header">
  <h1>Pelanggan</h1>
</div>

<div class="row mt-3">
  <div class="col-12 col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Daftar Token APi</h4>
      </div>
      <div class="card-body">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Token</button>
        <div class="table-responsive table-invoice">
          <table class="table" id="myTable">
            <thead>
              <tr>
                <th>No</th>
                <th>Token Name</th>
                <th>Token Api</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($apiTokens as $row)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->id }}|{{ $row->token }}</td>
                <td>
                  <form action="/admin/settings/api/{{ $row->id }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')"><i class="fas fa-trash"></i></button>
                  </form>
                </td>
              </tr>
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
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Formulir</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/admin/settings/api" method="post">
        @csrf
        @method('post')
        <div class="modal-body">
          <input type="text" class="form-control" name="token_name">
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="submit" class="btn btn-primary">Buat</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>

@livewireScripts
@stack('js')
@endsection