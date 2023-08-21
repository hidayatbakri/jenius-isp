<?php

namespace App\Http\Livewire;

use App\Models\Olt;
use App\Models\Telnet;
use Livewire\Component;

class GetOnu extends Component
{
    public $data;
    public $realtime = [];

    public function mount()
    {
        $telnet = new Telnet();
        $getactiveolt = Olt::where('status', 1)->first();
        $onuUncfg = [];
        if ($getactiveolt != null) {
            $result = $telnet->Connect($getactiveolt->host, $getactiveolt->user, $getactiveolt->password, $getactiveolt->port);
            if ($result == 0) {
                // cek ketersediaan port
                $output = $telnet->runCommand('show gpon onu uncfg');
                $telnet->Disconnect();
                $onuUncfg = Telnet::processOutput($output);
            }
        }
        $this->data = $onuUncfg;
    }

    public function render()
    {
        return view('livewire.get-onu');
    }

    protected $listeners = ['getData' => 'getData'];

    public function getData()
    {
        $telnet = new Telnet();
        $getactiveolt = Olt::where('status', 1)->first();
        $onuUncfg = [];
        if ($getactiveolt != null) {
            $result = $telnet->Connect($getactiveolt->host, $getactiveolt->user, $getactiveolt->password, $getactiveolt->port);
            if ($result == 0) {
                // cek ketersediaan port
                $output = $telnet->runCommand('show gpon onu uncfg');
                $telnet->Disconnect();
                $onuUncfg = Telnet::processOutput($output);
            }
        }
        $this->data = $onuUncfg;
    }
}
