<table class="table" id="dataTable">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Aktif</th>
      <th>Expire</th>
      <th>Status</th>
      <th>Tx</th>
      <th>Rx</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($customers as $tableRow)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $tableRow->customer->name ?? '' }}</td>
      <td>{{ $tableRow->customer->active ?? '' }}</td>
      <td>{{ $tableRow->customer->expire ?? '' }}</td>
      <td>
        @if($tableRow->customer->expire == null && $tableRow->customer->expire <= $now) <span class="text-warning">Tidak Aktif</span>
          @else
          <span class="text-success">Aktif</span>
          @endif
      </td>
      @if(isset($dataPower[$tableRow->customer->onu]) != null)
      @foreach($dataPower[$tableRow->customer->onu] as $pd)
      <td>
        @if($pd['tx'] > 6.980)
        <div class="badge btn-danger badge-sm">{{ $pd['tx'] }}
          @else
          <div class="badge btn-success badge-sm">{{ $pd['tx'] }}
            @endif
      </td>
      <td>
        @if($pd['rx'] < -13.300) <div class="badge btn-danger badge-sm">{{ $pd['rx'] }}</div>
          @else
          <div class="badge btn-success badge-sm">{{ $pd['rx'] }}</div>
          @endif
      </td>
      @endforeach
      @else
      <td></td>
      <td></td>
      @endif
      <td>
        <a href="/admin/customers/{{ $tableRow->customer->id }}" class="badge badge-sm bg-primary border-0">Detail</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@push('js')
<script>
  setInterval(() => {
    Livewire.emit('getData');
  }, 1000)
  setInterval(() => {
    Livewire.emit('getPower');
  }, 10000)
</script>
@endpush