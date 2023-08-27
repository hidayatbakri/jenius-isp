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
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
  }

  .marker2 {
    background-image: url("/assets/img/marker2.png");
    background-size: cover;
    width: 30px;
    height: 30px;
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
  <h1>Lokasi Alat</h1>
</div>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/tools">Alat</a></li>
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
  const data = JSON.parse(@json($tools));
  const getcustomers = JSON.parse(@json($customers));
  let dataodp = [];
  let totalcust = [];
  mapboxgl.accessToken =
    "pk.eyJ1IjoibWhtbWRkYXJ5bDExMCIsImEiOiJjbGxsbTJvYXQxcjJsM2xuczFheGhvYnd2In0.snzr5dOuhxwndWXQi8Tfog";

  const map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v12",
    center: [118.6982552, -1.6474952],
    zoom: 5,
  });

  const features = [];
  let i = 0,
    j = 0;
  data.forEach(item => {
    const {
      latitude,
      longitude,
      name,
      address,
      id,
      odp,
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
        totalOdp: odp.length,
        id: id,
      },
    };
    odp.push({
      'odc': name
    })
    dataodp.push(odp);
    features.push(geojsonFeature);
    i++;
  });

  getcustomers.forEach(item => {
    const {
      id,
      customer,
    } = item;
    const dataCust = {
      id: customer.length > 0 ? customer[0].odp_id : 0,
      totalCustomer: customer.length > 0 ? customer.length : 0,
    }
    totalcust.push(dataCust)

    j++;
  });

  const geojson = {
    type: "FeatureCollection",
    features: features,
  };

  const features2 = [];
  for (let i = 0; i < dataodp.length; i++) {
    if (dataodp[i].length > 1) {
      for (let j = 0; j < dataodp[i].length - 1; j++) {
        let getodp = dataodp[i][j]
        let getodc = dataodp[i][dataodp[i].length - 1]
        const geojsonFeature2 = {
          type: "Feature",
          geometry: {
            type: "Point",
            coordinates: [parseFloat(getodp.longitude), parseFloat(getodp.latitude)],
          },
          properties: {
            title: getodp.name,
            address: getodp.address,
            odc: getodc.odc,
            id: getodp.id,
          },
        };

        features2.push(geojsonFeature2);
      }
    }
  }

  for (var k = 0; k < features2.length; k++) {
    var idFound = false;
    for (var l = 0; l < totalcust.length; l++) {
      if (totalcust[l].id === features2[k].properties.id) {
        features2[k].properties.totalCustomer = totalcust[l].totalCustomer;
        idFound = true;
        break;
      }
    }
    if (!idFound) {
      features2[k].properties.totalCustomer = 0;
    }
  }


  const geojson2 = {
    type: "FeatureCollection",
    features: features2,
  };


  for (const feature of geojson.features) {
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
            <li class="list-group-item">Total Odp : ${feature.properties.totalOdp}</li>
            <li class="list-group-item">Detail : <a href="/admin/odc/${feature.properties.id}">Buka <i class="fas fa-external-link-alt px-1"></i></a></li>
          </ul>
          `
        )
      )
      .addTo(map);
  }

  for (const feature2 of geojson2.features) {
    // create a HTML element for each feature2
    const el = document.createElement("div");
    el.className = "marker2";

    new mapboxgl.Marker(el)
      .setLngLat(feature2.geometry.coordinates)
      .setPopup(
        new mapboxgl.Popup({
          offset: 25
        }) // add popups
        .setHTML(
          `
          <ul class="list-group list-group-flush ">
            <li class="list-group-item">Nama : ${feature2.properties.title}</li>
            <li class="list-group-item">Alamat : ${feature2.properties.address}</li>
            <li class="list-group-item">Odc : ${feature2.properties.odc}</li>
            <li class="list-group-item">Total Pelanggan : ${feature2.properties.totalCustomer}</li>
            <li class="list-group-item">Detail : <a href="/admin/odp/${feature2.properties.id}">Buka <i class="fas fa-external-link-alt px-1"></i></a></li>
          </ul>
          `
        )
      )
      .addTo(map);
  }
</script>
@endsection