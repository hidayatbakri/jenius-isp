@extends('admin.template.dashboard')
@section('container')


<!-- <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/settings/transaction">Pengaturan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
  </ol>
</nav> -->

<div class="row mt-3">
  <div class="col-6 col-sm-12 col-lg-6">
    <div class="section-header">
      <h1>Pengaturan Transaksi</h1>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Detail Transaksi</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive table-invoice">
              <table class="table">
                <tr>
                  <th>Biaya Admin</th>
                  <td>:</td>
                  <td>Rp. {{ number_format($transactionSettings->biaya_admin ?? '0' ,0,'.', '.') }}</td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td>:</td>
                  <td>{{ $transactionSettings->status_production ?? '' == 1 ? "Produksi" : "Simulasi" }}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Ubah Pengaturan Transaksi</h4>
          </div>
          <div class="card-body">
            @if($transactionSettings != null)
            <form action="/admin/settings/transaction/{{ $transactionSettings->id }}" method="post">
              @csrf
              @method('post')
              <div class="form-group">
                <input type="number" name="biaya_admin" placeholder="Biaya Admin" class="form-control">
              </div>
              <div class="form-group">
                <input type="radio" name="status_production" value="1" id="produksi"> <label for="produksi">Produksi</label>
                <input type="radio" name="status_production" class="ms-3" checked value="0" id="simulasi"> <label for="simulasi">Simulasi</label>
              </div>
              <div class="d-flex justify-content-end">
                <button class="btn btn-primary" type="submit">Perbarui</button>
              </div>
            </form>
            @else
            <form action="/admin/settings/transaction" method="post">
              @csrf
              @method('post')
              <div class="form-group">
                <input type="number" name="biaya_admin" placeholder="Biaya Admin" class="form-control">
              </div>
              <div class="form-group">
                <input type="radio" name="status_production" value="1" id="produksi"> <label for="produksi">Produksi</label>
                <input type="radio" name="status_production" class="ms-3" checked value="0" id="simulasi"> <label for="simulasi">Simulasi</label>
              </div>
              <div class="d-flex justify-content-end">
                <button class="btn btn-primary" type="submit">Tambah</button>
              </div>
            </form>

            @endif
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="col-6 col-sm-12 col-lg-6">
    <div class="section-header">
      <h1>Pengaturan Paket</h1>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Paket Details</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive table-invoice">
              <table class="table">
                <tr>
                  <th>No</th>
                  <th>Kecepatan</th>
                  <th>Harga</th>
                  <th>Action</th>
                </tr>
                @foreach($paket as $pk)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{$pk->speed ?? ''}}mbps</td>
                  <td>{{ number_format($pk->price ?? '0' ,0,'.', '.') }}</td>
                  <td>
                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                      Ubah Data
                    </button>
                  </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="/admin/settings/paket/{{ $pk->id }}" method="post">
                        @csrf
                        @method('post')
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Paket</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <input type="number" name="speed" placeholder="Kecepatan" class="form-control" value="{{ $pk->speed ?? '' }}">
                          </div>
                          <div class="form-group">
                            <input type="number" name="price" placeholder="Harga paket" class="form-control" value="{{ $pk->price ?? '' }}">
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Tambah Paket</h4>
          </div>
          <div class="card-body">
            <form action="/admin/settings/paket" method="post">
              @csrf
              @method('post')
              <div class="form-group">
                <input type="number" name="speed" placeholder="Kecepatan" class="form-control">
              </div>
              <div class="form-group">
                <input type="number" name="price" placeholder="Harga paket" class="form-control">
              </div>
              <div class="d-flex justify-content-end">
                <button class="btn btn-primary" type="submit">Tambah</button>
              </div>
            </form>
          </div>
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

@endsection