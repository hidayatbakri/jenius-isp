@extends('admin.template.dashboard')
@section('container')

<style>
  body {
    margin: 0;
    padding: 0;
  }

  #map {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 90%;
    margin: 50px;
  }

  .marker {
    background-image: url("/assets/img/marker.png");
    background-size: cover;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
  }

  .mapboxgl-popup {
    max-width: 200px;
  }

  .mapboxgl-popup-content {
    font-size: 11px;
    font-family: "Open Sans", sans-serif;
  }

  .card {
    min-height: 90vh;
  }
</style>

<div class="section-header">
  <h1>Lokasi Pelanggan</h1>
</div>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/customers">Pelanggan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Map</li>
  </ol>
</nav>
<div class="row">
  <div class="col-12 col-sm-12 col-lg-12">
    <div class="card" style="position: relative !important;">
      <div class="card-header">
        <h4>Map</h4>
      </div>
      <div class="card-body">
        <div id='map'></div>
      </div>
    </div>
  </div>
</div>

<script>
  const data = JSON.parse(@json($customers));
  mapboxgl.accessToken =
    "pk.eyJ1IjoibWhtbWRkYXJ5bDExMCIsImEiOiJjbGxsbTJvYXQxcjJsM2xuczFheGhvYnd2In0.snzr5dOuhxwndWXQi8Tfog";

  const map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v12",
    center: [118.6982552, -1.6474952],
    zoom: 5,
  });

  const features = [];
  data.forEach(item => {
    const {
      latitude,
      longitude,
      name,
      address,
      id,
      hp,
    } = item;

    const geojsonFeature = {
      type: "Feature",
      geometry: {
        type: "Point",
        coordinates: [parseFloat(longitude), parseFloat(latitude)],
      },
      properties: {
        title: name,
        address: address,
        id: id,
        hp: hp,
      },
    };
    features.push(geojsonFeature);
  });

  const geojson = {
    type: "FeatureCollection",
    features: features,
  };

  console.log(geojson);

  for (const feature of geojson.features) {
    // create a HTML element for each feature
    const el = document.createElement("div");
    el.className = "marker";

    new mapboxgl.Marker(el)
      .setLngLat(feature.geometry.coordinates)
      .setPopup(
        new mapboxgl.Popup({
          offset: 25
        }) // add popups
        .setHTML(
          `
          <ul class="list-group list-group-flush ">
            <li class="list-group-item">Nama : ${feature.properties.title}</li>
            <li class="list-group-item">Alamat : ${feature.properties.address}</li>
            <li class="list-group-item">Hp : ${feature.properties.hp}</li>
            <li class="list-group-item">Detail : <a href="/admin/customers/${feature.properties.id}">Buka <i class="fas fa-external-link-alt px-1"></i></a></li>
          </ul>
          `
        )
      )
      .addTo(map);
  }
</script>
@endsection