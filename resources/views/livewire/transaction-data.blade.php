<div>
  <div class="row">
    <div class="col-xl-3 col-lg-6">
      <div class="card">
        <div class="card-body card-type-3">
          <div class="row">
            <div class="col">
              <h6 class="text-muted mb-0">Client PPOE</h6>
              <span class="fw-bold mb-0">{{ count($customers ?? []) }}</span>
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
    <div class="col-xl-3 col-lg-6">
      <div class="card">
        <div class="card-body card-type-3">
          <div class="row">
            <div class="col">
              <h6 class="text-muted mb-0">Data Uncfg</h6>
              <span class="fw-bold mb-0">{{ count($uncfg) }}</span>
            </div>
            <div class="col-auto">
              <div class="card-circle l-bg-orange text-white">
                <i class="fas fa-question"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-sm-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>Daftar Pelanggan</h4>
        </div>
        <div class="card-body">
          <div class="list-link mb-4">
            <a href="/admin/customers/map" class="btn btn-primary"><i class="fas fa-map-marker-alt"></i> Lokasi Pelanggan</a>
            <!-- <a href="/admin/customers/refresh" class="btn btn-info"><i class="fas fa-sync-alt"></i> Refresh Data</a> -->
          </div>
          <div class="table-responsive table-invoice">

            <div>
              @if($message != null)
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Pesan!</strong> {{$message}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @endif
            </div>
            <table class="table table-bordered table-striped" id="dataTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Onu</th>
                  <th>SN</th>
                  <th>Onu Status</th>
                  <th>Up</th>
                  <th>Down</th>
                  <th>Reason State</th>
                  <th>Expired</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($customers ?? [] as $row)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $row['name'] }}</td>
                  <td>{{ $row['onuinterface'] }}</td>
                  <td>{{ $row['serialnumber'] }}</td>
                  <td>{{ $row['onustatus'] }}</td>
                  <td>
                    @if(isset($dataPower[$row["onuinterface"]]["up"]))
                    <div class="btn badge btn-sm {{ $dataPower[$row['onuinterface']]['up']['rx'] < -28 ? 'badge-danger' : 'badge-success' }}">Rx:{{$dataPower[$row["onuinterface"]]["up"]["rx"] }}</div>
                    <div class="btn badge btn-sm badge-success">Tx:{{$dataPower[$row["onuinterface"]]["up"]["tx"] }}</div>
                    @endif
                  </td>
                  <td>
                    @if(isset($dataPower[$row["onuinterface"]]["down"]))
                    <div class="btn badge btn-sm {{ $dataPower[$row['onuinterface']]['up']['tx'] < -28 ? 'badge-danger' : 'badge-success' }}">Rx:{{$dataPower[$row["onuinterface"]]["down"]["tx"]}}</div>
                    <div class="btn badge btn-sm badge-success">Tx:{{$dataPower[$row["onuinterface"]]["down"]["rx"]}}</div>
                    @endif
                  </td>
                  <td>
                    @if($row['phasestate'] == 'working')
                    Online
                    @elseif($row['phasestate'] == 'DyingGasp')
                    Power Mati
                    @elseif($row['phasestate'] == 'los')
                    Gangguan FO
                    @elseif($row['phasestate'] == 'offline')
                    Shutdown/Disable
                    @endif
                  </td>
                  @if(count($dbcustomers) > 0)
                  @if($results[$row['onuinterface']]['status'])
                  <td>
                    {{ isset($results[$row['onuinterface']]['exp']) ? $results[$row['onuinterface']]['exp'] : 'Belum Membayar' }}
                  </td>
                  @else
                  <td>-</td>
                  @endif
                  @endif
                  <td>
                    <div class="d-flex">
                      @if(count($dbcustomers) > 0)
                      @if(!$results[$row['onuinterface']]['status'])
                      <form action="/admin/customers/configure" method="post">
                        @csrf
                        @method('post')
                        <input type="hidden" name="onu" value="{{ $row['onuinterface'] }}">
                        <button type="submit" class="btn btn-warning me-1">Konfigurasi</button>
                      </form>
                      @endif
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                          Menu
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="/admin/customers/{{ isset($results[$row['onuinterface']]['id']) ? $results[$row['onuinterface']]['id'] : '' }}">Detail</a></li>
                          <li><a class="dropdown-item" href="/admin/onu/comm/remote">Remot Onu</a></li>
                          <li><a class="dropdown-item" href="/admin/onu/comm/reboot?onu={{$row['onuinterface']}}">Reboot</a></li>
                          <li><a class="dropdown-item" href="/admin/onu/comm/reset">Reset Factory</a></li>
                          <li><a class="dropdown-item" href="/admin/onu/comm/status">{{ $row['onustatus'] ? 'Disable' : 'Enable' }}</a></li>
                          <li>
                            <form action="/admin/customers/{{ isset($results[$row['onuinterface']]['id']) ? $results[$row['onuinterface']]['id'] : '999999' }}" method="post">
                              @csrf
                              @method('delete')
                              <input type="hidden" name="onu" value="{{ $row['onuinterface'] }}">
                              <button class="dropdown-item text-danger" onclick="return confirm('Apakah anda yakin? [{{$row->onuinterface }}]' )">Hapus</button>
                            </form>
                          </li>
                        </ul>
                      </div>
                      @else
                      <form action="/admin/customers/configure" method="post">
                        @csrf
                        @method('post')
                        <input type="hidden" name="onu" value="{{ $row['onuinterface'] }}">
                        <button type="submit" class="btn btn-warning me-1">Konfigurasi</button>
                      </form>
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                          Menu
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="/admin/customers/{{ isset($results[$row['onuinterface']]['id']) ? $results[$row['onuinterface']]['id'] : '' }}">Detail</a></li>
                          <li><a class="dropdown-item" href="/admin/onu/comm/remote">Remot Onu</a></li>
                          <li><a class="dropdown-item" href="/admin/onu/comm/reboot?onu={{$row['onuinterface']}}">Reboot</a></li>
                          <li><a class="dropdown-item" href="/admin/onu/comm/reset">Reset Factory</a></li>
                          <li><a class="dropdown-item" href="/admin/onu/comm/status">{{ $row['onustatus'] ? 'Disable' : 'Enable' }}</a></li>
                          <li>
                            <form action="/admin/customers/{{ isset($results[$row['onuinterface']]['id']) ? $results[$row['onuinterface']]['id'] : '999999' }}" method="post">
                              @csrf
                              @method('delete')
                              <!-- <input type="text" name="onu" value="{{ $row['onuinterface'] }}"> -->
                              <button class="dropdown-item text-danger" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                            </form>
                          </li>
                        </ul>
                      </div>
                      @endif
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class=" mt-5 alert alert-info alert-dismissible fade show" role="alert">
              <h4 class="alert-heading">Informasi </h4>
              <hr>
              <h6>Jika muncul tombol konfigurasi</h6>
              <ul>
                <li>Penyebab: Data ditambahkan tidak melalui sistem JENIUS-ISP tetapi melalui luar sistem/aplikasi</li>
                <li>Mengatasi: Silahkan melakukan konfigurasi (tombol konfigurasi) dengan mengisi formulir yang dibutuhkan</li>
              </ul>
              <h6>Tampilan data</h6>
              <ul>
                <li>Otomatis: Data akan di perbarui setiap 10 menit</li>
                <li>Manual: Gunakan tombol refresh data untuk memperbarui data</li>
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-sm-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>Onu Unconfig</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive table-invoice">
            <table class="table" id="dataTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Onu Index</th>
                  <th>Serial Number</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($uncfg as $rowuncfg)
                @if(is_array($rowuncfg))
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $rowuncfg['onuindex'] ?? '' }}</td>
                  <td>{{ $rowuncfg['sn'] ?? '' }}</td>
                  <td>
                    <form action="/admin/customers/create" method="get">
                      @csrf
                      <input type="hidden" name="onuIndex" value="{{ $rowuncfg['onuindex'] ?? '' }}">
                      <input type="hidden" name="getSn" value="{{ $rowuncfg['sn'] ?? '' }}">
                      <button class="border-0 badge badge-primary">Gunakan</button>
                    </form>
                  </td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('js')
<script>
  Livewire.on('refreshProfiles', function() {
    setTimeout(() => {
      Livewire.emit('getData');
    }, 10000)
  });
  Livewire.on('refreshPowers', function() {
    setTimeout(() => {
      console.log('sdf')
      Livewire.emit('getPower');
    }, 10000)
  });
  Livewire.on('refreshUncfg', function() {
    setTimeout(() => {
      Livewire.emit('getUncfg');
    }, 12000)
  });





  setTimeout(() => {
    Livewire.emit('getUncfg');
  }, 1500)
  setTimeout(() => {
    Livewire.emit('getData');
  }, 100)
  setTimeout(() => {
    Livewire.emit('getPower');
  }, 200)
  // setTimeout(() => {
  //   Livewire.emit('refresh');
  // }, 2500)
</script>
@endpush