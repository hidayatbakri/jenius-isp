@extends('admin.template.dashboard')
@section('container')


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/tools">Alat</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail alat</li>
  </ol>
</nav>

<div class="row">
  <div class="col-7 col-sm-7 col-lg-7">
    <div class="card">
      <div class="card-header">
        <h4>Detail Alat</h4>
      </div>
      <div class="card-body">
        @if($type == 'odc')
        <form action="/admin/odc/{{ $odc->id }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('put')
          <div class="form-group" id="show-olt">
            <label for="type">Olt: </label>
            <select name="olt_id" id="olt_id" class="form-control @error('olt_id') is-invalid @enderror">
              @foreach($olt as $o)
              @if($o['id'] == $odc->olt_id)
              <option selected value="{{ $o['id'] }}">Selected : {{ $o['host'] }}</option>
              @else
              <option value="{{ $o['id'] }}">{{ $o['host'] }}</option>
              @endif
              @endforeach
            </select>
            @error('olt_id')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="name">Nama Alat:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $odc->name }}">
            @error('name')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="head">Head Alat:</label>
            <input type="text" class="form-control @error('head') is-invalid @enderror" name="head" id="head" value="{{ $odc->head }}">
            @error('head')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="foto">Foto:</label>
            <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" value="{{ $odc->foto }}">
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
                <input type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" placeholder="Latitude" id="latitude" value="{{ $odc->latitude }}">
                @error('latitude')
                <div id="validationServer04Feedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              <div class="col-6">
                <input type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" placeholder="Longitude" id="longitude" value="{{ $odc->longitude }}">
                @error('longitude')
                <div id="validationServer04Feedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              <div class="form-group mt-4">
                <label for="address">Alamat:</label>
                <textarea name="address" id="address" class="form-control">{{ $odc->address }}</textarea>
                @error('address')
                <div id="validationServer04Feedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea name="description" id="description" class="form-control">{{ $odc->description }}</textarea>
                @error('description')
                <div id="validationServer04Feedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <a href="/admin/tools" class="btn btn-secondary me-2">Kembali</a>
            <button class="btn btn-primary">Simpan</button>
          </div>
        </form>
        @endif
        @if($type == 'odp')
        <form action="/admin/odp/{{ $tool->id }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('put')
          <div class="form-group">
            <label for="name">Nama Alat:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $tool->name }}">
            @error('name')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="head">Head Alat:</label>
            <input type="text" class="form-control @error('head') is-invalid @enderror" name="head" id="head" value="{{ $tool->head }}">
            @error('head')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="odc_id">Terhubung ke (Odc): </label>
            <select name="odc_id" id="odc_id" class="form-control">
              <option value="{{$tool->id}}">Selected : {{$tool->odc->name}}</option>
              @foreach($odc as $setodc)
              @if($tool->odc->name != $setodc->name)
              <option value="{{$setodc->id}}">{{$setodc->name}} [{{count($setodc->odp)}}/{{$setodc->port}}]</option>
              @endif
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="foto">Foto:</label>
            <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" value="{{ $tool->foto }}">
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
                <input type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" placeholder="Latitude" id="latitude" value="{{ $tool->latitude }}">
                @error('latitude')
                <div id="validationServer04Feedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              <div class="col-6">
                <input type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" placeholder="Longitude" id="longitude" value="{{ $tool->longitude }}">
                @error('longitude')
                <div id="validationServer04Feedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              <div class="form-group mt-4">
                <label for="address">Alamat:</label>
                <textarea name="address" id="address" class="form-control">{{ $tool->address }}</textarea>
                @error('address')
                <div id="validationServer04Feedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea name="description" id="description" class="form-control">{{ $tool->description }}</textarea>
                @error('description')
                <div id="validationServer04Feedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <a href="/admin/tools" class="btn btn-secondary me-2">Kembali</a>
            <button class="btn btn-primary">Simpan</button>
          </div>
        </form>
        @endif
      </div>
    </div>
  </div>
</div>


@livewireScripts
@stack('js')
@endsection