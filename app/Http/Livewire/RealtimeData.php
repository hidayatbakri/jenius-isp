<?php

namespace App\Http\Livewire;

use App\Models\RouterosAPI;
use Livewire\Component;

class RealtimeData extends Component
{
    public $data;
    public $realtime = [];
    public function mount($router)
    {
        $this->data = $router;
        $this->realtime["ip"] = $router->ip;
        $this->realtime["username"] = $router->username;
        $this->realtime["password"] = $router->password;

        $ip = $router->ip;
        $user = $router->username;
        $pass = $router->password;
        $API = new RouterosAPI();
        $API->debug('false');
        $commandApi = '/system/resource/print';

        if ($API->connect($ip, $user, $pass)) {
            $this->data =  $API->comm($commandApi)[0];
        } else {
            $this->data = "Failed";
        }
    }

    public function render()
    {
        return view('livewire.realtime-data');
    }


    protected $listeners = ['getData' => 'connectMikrotik'];

    public function connectMikrotik()
    {
        $ip = $this->realtime["ip"];
        $user = $this->realtime["username"];
        $pass = $this->realtime["password"];
        $API = new RouterosAPI();
        $API->debug('false');
        $commandApi = '/system/resource/print';

        if ($API->connect($ip, $user, $pass)) {
            $this->data =  $API->comm($commandApi)[0];
            return $API;
        } else {
            $this->data = "Failed";
        }
    }
}
