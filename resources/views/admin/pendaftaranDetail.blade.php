@extends('admin.template.dashboard')
@section('container')

<div class="section-header">
  <h1>Detail Pelanggan</h1>
</div>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/customers">Pendaftaran</a></li>
    <li class="breadcrumb-item active" aria-current="page">Library</li>
  </ol>
</nav>

<div class="row">
  <div class="col-5 col-sm-12 col-lg-5">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Detail Pelanggan</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive table-invoice">
              <table class="table">
                <tr>
                  <td>Nama</td>
                  <td>:</td>
                  <td>{{$customer->name}}</td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td>:</td>
                  <td>{{$customer->email}}</td>
                </tr>
                <tr>
                  <td>Telepon</td>
                  <td>:</td>
                  <td>{{$customer->hp}}</td>
                </tr>
                <tr>
                  <td>Nik</td>
                  <td>:</td>
                  <td>{{$customer->nik}}</td>
                </tr>
                <tr>
                  <td>Paket</td>
                  <td>:</td>
                  <td>{{$customer->speed}}mbps</td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td>:</td>
                  <td>{{$customer->address}}</td>
                </tr>
                <tr>
                  <td>Foto Ktp</td>
                  <td>:</td>
                  <td>
                    <img class="mt-3 rounded" style="object-fit:cover; width: 300px;" src="/storage/{{ $customer->foto_ktp }}" alt="">
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="card">
        <div class="card-header">
          <h4>Detail Olt</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive table-invoice">
            <table class="table">
              <tr>
                <td>Onu</td>
                <td>:</td>
                <td>gpon-onu_{{$customer->onu}}</td>
              </tr>
              <tr>
                <td>Tipe</td>
                <td>:</td>
                <td>{{$customer->type}}</td>
              </tr>
              <tr>
                <td>Serial Number</td>
                <td>:</td>
                <td>{{$customer->sn}}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-7 col-sm-12 col-lg-7">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Detail Transaksi</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive table-invoice">
              <table class="table" id="myTable">
                <thead>
                  <th>No</th>
                  <th>Order Id</th>
                  <th>Transaction Id</th>
                  <th>Gross Amount</th>
                  <th>Payment Type</th>
                  <th>Payment Link</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                </thead>
                <tbody>
                  @foreach($customers as $rowC)
                  @foreach($rowC->transactions as $tr)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tr->order_id }}</td>
                    <td>{{ $tr->transaction_id }}</td>
                    <td>Rp. {{ number_format($tr->gross_amount, 0, ".", ".") }}</td>
                    <td>{{ $tr->payment_type }}</td>
                    <td><a href="https://app.sandbox.midtrans.com/payment-links/{{ $tr->paymentlink }}" target="_blank">Buka Situs</a></td>
                    <td>
                      @if($tr->status_code == 200)
                      <div class="badge badge-sm bg-success">Dibayar</div>
                      @elseif($tr->status_code == 201)
                      <div class="badge badge-sm bg-warning">Pending</div>
                      @else
                      <div class="badge badge-sm bg-secondary">Gagal</div>
                      @endif
                    </td>
                    <td>{{ $tr->updated_at }}</td>
                  </tr>
                  @endforeach
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection