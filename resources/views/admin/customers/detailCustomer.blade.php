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
                  <td>{{$customer->address}} ( <a target="_blank" href="https://google.com/maps/place/{{$customer->latitude}},{{ $customer->longitude }}">Map <i class="fas fa-external-link-alt px-1"></i></a> )</td>
                </tr>
                <tr>
                  <td>Foto Ktp</td>
                  <td>:</td>
                  <td>
                    <img class="mt-3 rounded" style="object-fit:cover; width: 300px;" src="/storage/{{ $customer->foto_ktp }}" alt="">
                  </td>
                </tr>
                <tr>
                  <td>Foto Rumah</td>
                  <td>:</td>
                  <td>
                    <img class="mt-3 rounded" style="object-fit:cover; width: 300px;" src="/storage/{{ $customer->foto_rumah }}" alt="">
                  </td>
                </tr>
              </table>
              <div class="d-flex justify-content-end">
                <a href="/admin" class="btn btn-primary my-3 px-3">Kembali</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-7 col-sm-12 col-lg-7">
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
              <td>{{$profile['onuinterface'] }}</td>
            </tr>
            <tr>
              <td>Tipe</td>
              <td>:</td>
              <td>{{$profile['type'] }}</td>
            </tr>
            <tr>
              <td>Serial Number</td>
              <td>:</td>
              <td>{{$profile['serialnumber'] }}</td>
            </tr>
            <tr>
              <td>State</td>
              <td>:</td>
              <td>{{$profile['state'] }}</td>
            </tr>
            <tr>
              <td>Phase State</td>
              <td>:</td>
              <td>{{$profile['phasestate'] }}</td>
            </tr>
            <tr>
              <td>Onu Distance</td>
              <td>:</td>
              <td>{{$profile['onudistance'] }}</td>
            </tr>
            <tr>
              <td>Online Duration</td>
              <td>:</td>
              <td>{{$profile['onlineduration'] }}</td>
            </tr>
            <tr>
              <td>Odp</td>
              <td>:</td>
              <td>{{$odp->name}} <a href="/admin/odp/{{ $odp->id }}" class=""><i class="fas fa-external-link-alt px-1"></i></a></td>
            </tr>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="row">
  <div class="col-12 col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Detail Transaksi</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive table-invoice">
          <table class="table" id="dataTable">
            <thead>
              <th>No</th>
              <th>Order Id</th>
              <th>Status</th>
              <th>Tipe Pembayaran</th>
              <th>Biaya</th>
              <th>Tanggal Di Bayar</th>
              <th>Link</th>
            </thead>
            <tbody>
              @foreach($customers as $customer)
              @foreach($customer->transactions as $tr)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tr->order_id }}</td>
                <td>{{ $tr->status_code == 200 ? 'Dibayar' : 'Belum Dibayar'}}</td>
                <td>{{ $tr->payment_type }}</td>
                <td>Rp. {{ number_format($tr->gross_amount,0, ".", ".") }}</td>
                <td>{{ $tr->date }}</td>
                <td><a href="https://app.sandbox.midtrans.com/payment-links/{{ $tr->paymentlink }}" target="_blank">https://app.sandbox.midtrans.com/payment-links/{{ $tr->paymentlink }}</a></td>
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



@endsection