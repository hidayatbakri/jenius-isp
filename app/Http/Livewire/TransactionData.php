<?php

namespace App\Http\Livewire;

use App\Events\ApiResponseReceived;
use App\Jobs\TelnetDataRetrievalJob;
use App\Jobs\TelnetStat;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\Olt;
use App\Models\Paket;
use App\Models\TelegramApi;
use App\Models\Telnet;
use App\Models\TelnetCache;
use App\Models\TelnetSingleton;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class TransactionData extends Component
{
    public $dataPower;
    public $customers = [];
    public $uncfg;
    public $dbcustomers;
    public $message;
    public $results = [];

    protected $listeners = ['getData' => 'getData', 'getPower' => 'getPower', 'getUncfg' => 'getUncfg', 'refresh' => 'refresh'];
    public function mount()
    {
        $this->uncfg = [];
        $this->message = "Mengambil data...";
    }

    public function render()
    {
        return view('livewire.transaction-data');
    }


    public function getData()
    {
        // $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
        //     ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
        //     ->get(env('OLT_API_URL') . 'api/olt/profiles');
        // $profiles = json_decode($response->getBody()->getContents(), true);
        // if (isset($profiles['message'])) {
        //     $this->customers = [];
        //     dump($profiles['message']);
        //     $this->message = "Data Kosong";
        // } else {
        //     if ($profiles != null) {
        //         $this->message = null;
        //         $this->customers = $profiles;
        //     }
        // }

        $responseOlt = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get(env('OLT_API_URL') . 'api/olt/getconnect');
        $olt = json_decode($responseOlt->getBody()->getContents(), true);
        $this->customers = CustomerProfile::where('olt_id', $olt['id'])->get();

        $this->dbcustomers = Customer::all();

        foreach ($this->customers ?? [] as $key => $data1) {
            $found = false;
            foreach ($this->dbcustomers ?? [] as $data2) {
                if (isset($data1["onuinterface"])) {
                    if ($data1["onuinterface"] == $data2->onu) {
                        $found = true;
                        $this->results[$data1->onuinterface]['id'] = $data2->id;
                        $this->results[$data1->onuinterface]['exp'] = $data2->expire;
                        break;
                    }
                }
            }
            $this->results[$data1->onuinterface]['status'] = $found;
        }
        $this->emit('refreshProfiles');
    }

    public function getPower()
    {
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get(env('OLT_API_URL') . 'api/olt/powers');
        $powers = json_decode($response->getBody()->getContents(), true);
        // dd($powers);

        if (isset($powers['message'])) {
            $this->dataPower = [];
        } else {
            $this->dataPower = $powers;
        }
        $this->emit('refreshPowers');
    }

    public function getUncfg()
    {
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get(env('OLT_API_URL') . 'api/olt/uncfg');
        $uncfg = json_decode($response->getBody()->getContents(), true);
        // dd($uncfg);
        if (isset($uncfg['message'])) {
            $this->uncfg = [];
        } else {
            $this->message = null;
            $this->uncfg = $uncfg;
        }
        $this->emit('refreshUncfg');
    }

    public function refresh()
    {
        $cp = new CustomerProfile();
        $cp->refresh();
    }
}
