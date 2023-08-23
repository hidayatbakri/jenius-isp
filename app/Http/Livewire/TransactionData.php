<?php

namespace App\Http\Livewire;

use App\Jobs\TelnetStat;
use App\Models\Customer;
use App\Models\Olt;
use App\Models\Paket;
use App\Models\TelegramApi;
use App\Models\Telnet;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class TransactionData extends Component
{
    public $dataPower;
    public $getactiveolt;
    public $customers;
    public $now;
    public $in = 0;
    public function mount()
    {
        $this->getactiveolt = Olt::where('status', 1)->first();
        $customers = Transaction::with('customer')->where('olt_id', $this->getactiveolt->id)->groupBy('customer_id')->get();
        $this->customers =  $customers;
    }

    public function render()
    {
        return view('livewire.transaction-data');
    }

    protected $listeners = ['getData' => 'getData', 'getPower' => 'getPower'];

    public function getData()
    {
        $customers = Transaction::with('customer')->where('olt_id', $this->getactiveolt->id)->groupBy('customer_id')->get();
        $this->customers =  $customers;
    }

    public function getPower()
    {
        // dd('asdf');
        $getactiveolt = Olt::where('status', 1)->first();
        $telnet = new Telnet();
        if ($getactiveolt != null) {
            $result = $telnet->Connect($getactiveolt->host, $getactiveolt->user, $getactiveolt->password, $getactiveolt->port);
            if ($result == 0) {
                $dataOlt = $telnet->getPowerFromArrayOfData($this->customers);
                $telnet->Disconnect();
                $data =  $dataOlt;
            }
        }
        $this->dataPower = $data;

        // $textReport = '';
        $telegramApi = new TelegramApi;
        foreach ($this->customers as $row) {
            if (isset($data[$row->customer->onu]) != null) {
                foreach ($data[$row->customer->onu] as $pd) {
                    if ($pd['tx'] > 6.980 || $pd['rx'] < -13.224) {
                        $textReport = "
⚠Informasi Gangguan⚠
Nama Pelanggan : " . $row->customer->name . "
Onu : " . $row->customer->onu . "
Olt : " . $getactiveolt->name . "
Sn : " . $row->customer->sn . "
Telepon : " . $row->customer->hp . "
TX : " . $pd['tx'] . "
RX : " . $pd['rx'] . "
Reason : Tes
Lokasi (map) : https://google.com/maps/place/" . $row->customer->latitude . "," . $row->customer->longitude . "
";
                        $telegramApi->sendMessage($textReport);
                    }
                }
            }
        }
    }

    public function getDateCustomers()
    {
        $this->now = Carbon::today()->format("Y-m-d");
        foreach ($this->customers as $row) {
            if ($row->customer->expire <= $this->now && $row->customer->expire != null) {
                $paket = Paket::where('id', $row->customer->paket)->first();
                $paymentLinkId =  preg_replace("/[^a-zA-Z0-9]/", '', base64_encode($row->customer->email . $row->customer->hp . rand(10, 9999999999)));
                $orderId = rand(1000, 1000000000000);
                $biayaAdmin = DB::table('transactionsettings')->first();
                $totalBiaya = $paket->price + $biayaAdmin->biaya_admin ?? 0;
                $response = Http::withBasicAuth("SB-Mid-server-m9r2dUIe58EggFEyTflF8orC:", "")
                    ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
                    ->withBody('{"transaction_details":{"order_id":"' . $orderId . '","gross_amount":' . $totalBiaya . ',"payment_link_id":"' . $paymentLinkId . '"},"credit_card":{"secure":true},"usage_limit":999,"expiry":{"duration":1,"unit":"days"},"item_details":[{"id":' . $paket->id . ',"name": "' . $paket->speed . 'mbps","price":' . $totalBiaya . ',"quantity":1}],"customer_details":{"first_name":"' . $row->customer->name . '","last_name":"","email":"' . $row->customer->email . '","phone":"' . $row->customer->hp . '","notes":"Terimakasih telah bertransaksi, selesaikan pembayaran untuk berlangganan."}}')
                    ->post('https://api.sandbox.midtrans.com/v1/payment-links');
                Transaction::create([
                    'customer_id' => $row->customer->id,
                    'status_code' => 201,
                    'transaction_id' => '',
                    'order_id' => $orderId,
                    'gross_amount' => $paket->price,
                    'payment_type' => '',
                    'transaction_code' => '',
                    'paymentlink' => $paymentLinkId,
                ]);


                Customer::where('id', $row->customer->id)->update([
                    'active' => null,
                    'expire' => null,
                ]);
            }
        }
    }
}
