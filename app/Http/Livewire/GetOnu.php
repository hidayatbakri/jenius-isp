<?php

namespace App\Http\Livewire;

use App\Models\Olt;
use App\Models\Telnet;
use App\Models\TelnetSingleton;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class GetOnu extends Component
{
    public $data = [];
    public $message;

    public function mount()
    {
        $this->message = "Mengambil data...";
    }

    public function render()
    {
        return view('livewire.get-onu');
    }

    protected $listeners = ['getData' => 'getData'];

    // public function getData()
    // {
    //     $telnet = new Telnet();
    //     $getactiveolt = Olt::where('status', 1)->first();
    //     $onuUncfg = [];
    //     if ($getactiveolt != null) {
    //         $result = $telnet->Connect($getactiveolt->host, $getactiveolt->user, $getactiveolt->password, $getactiveolt->port);
    //         if ($result == 0) {
    //             // cek ketersediaan port
    //             $output = $telnet->runCommand('show gpon onu uncfg');
    //             $telnet->Disconnect();
    //             $onuUncfg = Telnet::processOutput($output);
    //         }
    //     }
    //     $this->data = $onuUncfg;
    // }

    public function getData()
    {
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get(env('OLT_API_URL') . 'api/olt/uncfg');
        $profiles = json_decode($response->getBody()->getContents(), true);

        if (isset($profiles['message'])) {
            $this->data = [];
            $this->message = "Data Kosong";
        } else {
            $this->message = null;
            $this->data = $profiles;
        }
    }
}
