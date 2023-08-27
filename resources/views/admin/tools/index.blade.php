@extends('admin.template.dashboard')
@section('container')

<div class="section-header">
  <h1>Alat</h1>
</div>
<div class="row">
  <div class="col-xl-3 col-lg-6">
    <div class="card">
      <div class="card-body card-type-3">
        <div class="row">
          <div class="col">
            <h6 class="text-muted mb-0">Total Alat (ODC)</h6>
            <span class="fw-bold mb-0">{{ count($odc) }}</span>
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
            <h6 class="text-muted mb-0">Total Alat (ODP)</h6>
            <span class="fw-bold mb-0">{{ count($odp) }}</span>
          </div>
          <div class="col-auto">
            <div class="card-circle l-bg-red text-white">
              <i class="fas fa-user"></i>
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
        <h4>Daftar Alat Odc</h4>
      </div>
      <div class="card-body">
        <div class="list-link mb-4">
          <button type="button" class="btn btn-success me-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Alat</button>
          <a href="/admin/tools/map" class="btn btn-primary">Lokasi Alat</a>
        </div>
        <div class="table-responsive table-invoice">
          <table class="table" id="dataTable2">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Alamat</th>
                <th>Map</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($odc as $row)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->address }}</td>
                <td>Buka <a target="_blank" href="https://google.com/maps/place/{{ $row->latitude }},{{ $row->longitude }}"><i class="fas fa-external-link-alt px-1"></i></a></td>
                <td>
                  <form action="/admin/odc/{{ $row->id }}" method="post">
                    @csrf
                    @method('delete')
                    <a href="/admin/odc/{{ $row->id }}" class="badge btn-primary">Detail</a>
                    <button type="button" class="badge btn-success mx-2" data-bs-toggle="modal" data-bs-target="#moreModal">Edit</button>
                    <button class="badge btn-danger" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                  </form>
                </td>
              </tr>

              <!-- modal edit -->
              <div class="modal fade" id="moreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form action="/admin/odc/{{ $row->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Formulir</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="name">Nama Alat:</label>
                          <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $row->name }}">
                          @error('name')
                          <div id="validationServer04Feedback" class="invalid-feedback">
                            {{$message}}
                          </div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="head">Head Alat:</label>
                          <input type="text" class="form-control @error('head') is-invalid @enderror" name="head" id="head" value="{{ $row->head }}">
                          @error('head')
                          <div id="validationServer04Feedback" class="invalid-feedback">
                            {{$message}}
                          </div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="foto">Foto:</label>
                          <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" value="{{ $row->foto }}">
                          @error('foto')
                          <div id="validationServer04Feedback" class="invalid-feedback">
                            {{$message}}
                          </div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="latitude">Lokasi Alat:</label>
                          <div class="row">
                            <div class="col-6">
                              <input type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" placeholder="Latitude" id="latitude" value="{{ $row->latitude }}">
                              @error('latitude')
                              <div id="validationServer04Feedback" class="invalid-feedback">
                                {{$message}}
                              </div>
                              @enderror
                            </div>
                            <div class="col-6">
                              <input type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" placeholder="Longitude" id="longitude" value="{{ $row->longitude }}">
                              @error('longitude')
                              <div id="validationServer04Feedback" class="invalid-feedback">
                                {{$message}}
                              </div>
                              @enderror
                            </div>
                            <div class="form-group mt-4">
                              <label for="address">Alamat:</label>
                              <textarea name="address" id="address" class="form-control">{{ $row->address }}</textarea>
                              @error('address')
                              <div id="validationServer04Feedback" class="invalid-feedback">
                                {{$message}}
                              </div>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="description">Deskripsi:</label>
                              <textarea name="description" id="description" class="form-control">{{ $row->description }}</textarea>
                              @error('description')
                              <div id="validationServer04Feedback" class="invalid-feedback">
                                {{$message}}
                              </div>
                              @enderror
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h4>Daftar Alat Odp</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive table-invoice">

          <table class="table" id="dataTable">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Alamat</th>
                <th>Map</th>
                <th>Odc</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($odp as $rodp)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $rodp->name }}</td>
                <td>{{ $rodp->address }}</td>
                <td>Buka <a target="_blank" href="https://google.com/maps/place/{{ $rodp->latitude }},{{ $rodp->longitude }}"><i class="fas fa-external-link-alt px-1"></i></a></td>
                <td>{{ $rodp->odc->name }}</td>
                <td>
                  <form action="/admin/tools/{{ $rodp->id }}" method="post">
                    @csrf
                    @method('delete')
                    <a href="/admin/odp/{{ $rodp->id }}" class="badge btn-primary">Detail</a>
                    <button type="button" class="badge btn-success mx-2" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                    <button class="badge btn-danger" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                  </form>
                </td>
              </tr>

              <!-- modal edit -->
              <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form action="/admin/odp/{{ $rodp->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Formulir</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="name">Nama Alat:</label>
                          <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $rodp->name }}">
                          @error('name')
                          <div id="validationServer04Feedback" class="invalid-feedback">
                            {{$message}}
                          </div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="head">Head Alat:</label>
                          <input type="text" class="form-control @error('head') is-invalid @enderror" name="head" id="head" value="{{ $rodp->head }}">
                          @error('head')
                          <div id="validationServer04Feedback" class="invalid-feedback">
                            {{$message}}
                          </div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="odc_id">Terhubung ke (Odc): </label>
                          <select name="odc_id" id="odc_id" class="form-control">
                            <option value="{{$rodp->odc->id}}">Selected : {{$rodp->odc->name}}</option>
                            @foreach($odc as $setodc)
                            <option value="{{$setodc->id}}">{{$setodc->name}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="foto">Foto:</label>
                          <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" value="{{ $rodp->foto }}">
                          @error('foto')
                          <div id="validationServer04Feedback" class="invalid-feedback">
                            {{$message}}
                          </div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="latitude">Lokasi Alat:</label>
                          <div class="row">
                            <div class="col-6">
                              <input type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" placeholder="Latitude" id="latitude" value="{{ $rodp->latitude }}">
                              @error('latitude')
                              <div id="validationServer04Feedback" class="invalid-feedback">
                                {{$message}}
                              </div>
                              @enderror
                            </div>
                            <div class="col-6">
                              <input type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" placeholder="Longitude" id="longitude" value="{{ $rodp->longitude }}">
                              @error('longitude')
                              <div id="validationServer04Feedback" class="invalid-feedback">
                                {{$message}}
                              </div>
                              @enderror
                            </div>
                            <div class="form-group mt-4">
                              <label for="address">Alamat:</label>
                              <textarea name="address" id="address" class="form-control">{{ $rodp->address }}</textarea>
                              @error('address')
                              <div id="validationServer04Feedback" class="invalid-feedback">
                                {{$message}}
                              </div>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="description">Deskripsi:</label>
                              <textarea name="description" id="description" class="form-control">{{ $rodp->description }}</textarea>
                              @error('description')
                              <div id="validationServer04Feedback" class="invalid-feedback">
                                {{$message}}
                              </div>
                              @enderror
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
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
    <form action="/admin/tools" method="post" enctype="multipart/form-data">
      @csrf
      @method('post')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Formulir</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="type">Tipe: </label>
            <select name="type" id="type" class="form-control">
              <option value="1">Odc</option>
              <option value="0">Odp</option>
            </select>
          </div>
          <div class="form-group">
            <label for="name">Nama Alat:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
            @error('name')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="head">Head Alat:</label>
            <input type="text" class="form-control @error('head') is-invalid @enderror" name="head" id="head" value="{{ old('head') }}">
            @error('head')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="foto">Foto:</label>
            <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" value="{{ old('foto') }}">
            @error('foto')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="latitude">Lokasi Alat:</label>
            <div class="row">
              <div class="col-6">
                <input type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" placeholder="Latitude" id="latitude" value="{{ old('latitude') }}">
                @error('latitude')
                <div id="validationServer04Feedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              <div class="col-6">
                <input type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" placeholder="Longitude" id="longitude" value="{{ old('longitude') }}">
                @error('longitude')
                <div id="validationServer04Feedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              <div class="form-group mt-4">
                <label for="address">Alamat:</label>
                <textarea name="address" id="address" class="form-control">{{ @old('address') }}</textarea>
                @error('address')
                <div id="validationServer04Feedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              <div class="form-group" id="list-odc"></div>
              <div class="form-group mt-4">
                <label for="description">Deskripsi:</label>
                <textarea name="description" id="description" class="form-control">{{ @old('description') }}</textarea>
                @error('description')
                <div id="validationServer04Feedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script>
  $('#type').on('click', function() {
    if ($('#type').val() == 0) {
      $('#list-odc').html(`
        <label for="odp">Terhubung ke (Odc): </label>
            <select name="odp" id="odp" class="form-control">
              @foreach($odc as $setodc)
              <option value="{{$setodc->id}}">{{$setodc->name}}</option>
              @endforeach
            </select>
      `);
    } else {
      $('#list-odc').html('');
    }
  });
</script>

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