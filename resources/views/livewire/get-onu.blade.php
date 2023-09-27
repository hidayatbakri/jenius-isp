<div>
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
            @foreach($data as $row)
            @if(is_array($row))
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row['onuindex'] ?? '' }}</td>
                <td>{{ $row['sn'] ?? '' }}</td>
                <td>
                    <form action="/admin/customers/create" method="get">
                        @csrf
                        <input type="hidden" name="onuIndex" value="{{ $row['onuindex'] ?? '' }}">
                        <input type="hidden" name="getSn" value="{{ $row['sn'] ?? '' }}">
                        <button class="border-0 badge badge-primary">Gunakan</button>
                    </form>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>

@push('js')
<script>
    setInterval(() => {
        Livewire.emit('getData')
    }, 2000)
</script>
@endpush