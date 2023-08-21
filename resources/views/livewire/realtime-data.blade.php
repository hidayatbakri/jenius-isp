    <div class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Router Info</h4>
                <table class="w-100">
                    <tr>
                        <td width="150px">Uptime</td>
                        <td>: </td>
                        <td> {{ $data['uptime'] }}</td>
                    </tr>
                    <tr>
                        <td>Board Name</td>
                        <td>: </td>
                        <td> {{ $data['board-name'] }}</td>
                    </tr>
                    <tr>
                        <td>Architecture Name</td>
                        <td>: </td>
                        <td> {{ $data['architecture-name'] }}</td>
                    </tr>
                    <tr>
                        <td>Version</td>
                        <td>: </td>
                        <td> {{ $data['version'] }}</td>
                    </tr>
                    <tr>
                        <td>Build Time</td>
                        <td>: </td>
                        <td> {{ $data['build-time'] }}</td>
                    </tr>
                    <tr>
                        <td>Platform</td>
                        <td>: </td>
                        <td> {{ $data['platform'] }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr class="w-100">
                        </td>
                    </tr>
                    <tr>
                        <td>Cpu</td>
                        <td>: </td>
                        <td> {{ $data['cpu'] }}</td>
                    </tr>
                    <tr>
                        <td>Cpu frequency</td>
                        <td>: </td>
                        <td> {{ $data['cpu-frequency'] }} MHz</td>
                    </tr>
                    <tr>
                        <td>Cpu load</td>
                        <td>: </td>
                        <td> {{ $data['cpu-load'] }}%</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr class="w-100">
                        </td>
                    </tr>
                    <tr>
                        <td>Free Memory</td>
                        <td>: </td>
                        <td> {{ ($data['free-memory'] / 1024) }} MiB</td>
                    </tr>
                    <tr>
                        <td>Total Memory</td>
                        <td>: </td>
                        <td> {{ ($data['total-memory'] / 1024) }} MiB</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        setInterval(() => {
            Livewire.emit('getData')
        }, 1000)
    </script>
    @endpush