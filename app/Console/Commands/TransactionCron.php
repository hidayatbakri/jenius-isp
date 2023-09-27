<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Paket;
use App\Models\TelegramApi;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::today()->format("Y-m-d");
        $telegramApi = new TelegramApi;

        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get(env('OLT_API_URL') . 'api/olt/profiles');
        $profiles = json_decode($response->getBody()->getContents(), true);
        isset($profiles['message']) ? $customers = [] : $customers = $profiles;

        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get(env('OLT_API_URL') . 'api/olt/powers');
        $powers = json_decode($response->getBody()->getContents(), true);
        isset($powers['message']) ? $dataPower = [] : $dataPower = $powers;

        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get(env('OLT_API_URL') . 'api/olt/getconnect');
        $olt = json_decode($response->getBody()->getContents(), true);


        $dbcustomers = Transaction::with('customer')->groupBy('customer_id')->get();
        foreach ($customers ?? [] as $key => $data1) {
            $found = false;

            foreach ($dbcustomers ?? [] as $data2) {
                if (isset($data1["onuinterface"])) {
                    if ($data1["onuinterface"] == $data2->customer->onu) {
                        $found = true;
                        $results[$data1['onuinterface']]['id'] = $data2->customer->id;
                        $results[$data1['onuinterface']]['exp'] = $data2->customer->expired;
                        $results[$data1['onuinterface']]['email'] = $data2->customer->email;
                        $results[$data1['onuinterface']]['paket'] = $data2->customer->paket_id;
                        $results[$data1['onuinterface']]['hp'] = $data2->customer->hp;
                        if (isset($dataPower[$data1["onuinterface"]]["up"])) {
                            if ($dataPower[$data1['onuinterface']]['up']['rx'] < -28) {
                                $textReport = "
⚠Informasi Gangguan⚠
Nama Pelanggan : " . $data1['name'] . "
Onu : " . $data1['onuinterface'] . "
Olt : " . $olt['data'] . "
Sn : " . $data1['serialnumber'] . "
Telepon : " . $data2->customer->hp . "
UP TX : " . $dataPower[$data1['onuinterface']]['up']['tx'] . "
UP RX : " . $dataPower[$data1['onuinterface']]['up']['rx'] . "
Reason : RX rendah
Lokasi (map) : https://google.com/maps/place/" . $data2->customer->latitude . "," . $data2->customer->longitude . "";
                                $telegramApi->sendMessage($textReport);
                            }
                        }
                        if (isset($dataPower[$data1["onuinterface"]]["down"])) {
                            if ($dataPower[$data1['onuinterface']]['down']['tx'] < -28) {
                                $textReport = "
⚠Informasi Gangguan⚠
Nama Pelanggan : " . $data1['name'] . "
Onu : " . $data1['onuinterface'] . "
Olt : " . $olt['data'] . "
Sn : " . $data1['serialnumber'] . "
Telepon : " . $data2->customer->hp . "
UP TX : " . $dataPower[$data1['onuinterface']]['down']['rx'] . "
UP RX : " . $dataPower[$data1['onuinterface']]['down']['tx'] . "
Reason : RX rendah
Lokasi (map) : https://google.com/maps/place/" . $data2->customer->latitude . "," . $data2->customer->longitude . "";
                                $telegramApi->sendMessage($textReport);
                            }
                        }

                        if ($data1['phasestate'] == 'los') {
                            $textReport = "
⚠Informasi Gangguan⚠
Nama Pelanggan : " . $data1['name'] . "
Onu : " . $data1['onuinterface'] . "
Olt : " . $olt['data'] . "
Sn : " . $data1['serialnumber'] . "
Telepon : " . $data2->customer->hp . "
Phase state : " . $data1['phasestate'] . "
Reason : Gangguan Kabel FO
Lokasi (map) : https://google.com/maps/place/" . $data2->customer->latitude . "," . $data2->customer->longitude . "";
                            $telegramApi->sendMessage($textReport);
                        }

                        break;
                    }
                }
            }
            $results[$data1['onuinterface']]['status'] = $found;

            if (isset($dataPower[$data1["onuinterface"]]["up"])) {
                if ($dataPower[$data1['onuinterface']]['up']['rx'] < -28) {
                    $textReport = "
⚠Informasi Gangguan⚠
Nama Pelanggan : " . $data1['name'] . "
Onu : " . $data1['onuinterface'] . "
Olt : " . $olt['data'] . "
Sn : " . $data1['serialnumber'] . "
UP TX : " . $dataPower[$data1['onuinterface']]['up']['tx'] . "
UP RX : " . $dataPower[$data1['onuinterface']]['up']['rx'] . "
Reason : RX rendah";
                    $telegramApi->sendMessage($textReport);
                }
            }
            if (isset($dataPower[$data1["onuinterface"]]["down"])) {
                if ($dataPower[$data1['onuinterface']]['down']['tx'] < -28) {
                    $textReport = "
⚠Informasi Gangguan⚠
Nama Pelanggan : " . $data1['name'] . "
Onu : " . $data1['onuinterface'] . "
Olt : " . $olt['data'] . "
Sn : " . $data1['serialnumber'] . "
UP TX : " . $dataPower[$data1['onuinterface']]['down']['rx'] . "
UP RX : " . $dataPower[$data1['onuinterface']]['down']['tx'] . "
Reason : RX rendah";
                    $telegramApi->sendMessage($textReport);
                }
            }

            if ($data1['phasestate'] == 'los') {
                $textReport = "
⚠Informasi Gangguan⚠
Nama Pelanggan : " . $data1['name'] . "
Onu : " . $data1['onuinterface'] . "
Olt : " . $olt['data'] . "
Sn : " . $data1['serialnumber'] . "
Phase state : " . $data1['phasestate'] . "
Reason : Gangguan Kabel FO";
                $telegramApi->sendMessage($textReport);
            }

            if ($results[$data1['onuinterface']]['status']) {
                if ($results[$data1['onuinterface']]['exp'] < $now && $results[$data1['onuinterface']]['exp'] != null) {
                    $biayaAdmin = DB::table('transactionsettings')->first();
                    $orderId = rand(1000, 1000000000000);
                    $paymentLinkId =  preg_replace("/[^a-zA-Z0-9]/", '', base64_encode($results[$data1['onuinterface']]['email'] . $results[$data1['onuinterface']]['hp'] . rand(10, 9999999999)));
                    $paket = Paket::where('id', $results[$data1['onuinterface']]['paket'])->first();
                    $totalBiaya = $paket->price ?? 0 + $biayaAdmin->biaya_admin ?? 0;
                    $response = Http::withBasicAuth("SB-Mid-server-m9r2dUIe58EggFEyTflF8orC:", "")
                        ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
                        ->withBody('{"transaction_details":{"order_id":"' . $orderId . '","gross_amount":' . $totalBiaya . ',"payment_link_id":"' . $paymentLinkId . '"},"credit_card":{"secure":true},"usage_limit":999,"expiry":{"duration":1,"unit":"days"},"item_details":[{"id":' . $paket->id . ',"name": "' . $paket->speed . 'mbps","price":' . $totalBiaya . ',"quantity":1}],"customer_details":{"first_name":"' . $data1["name"] . '","last_name":" ","email":"' . $results[$data1['onuinterface']]['email'] . '","phone":"' . $results[$data1['onuinterface']]['hp'] . '","notes":"Terimakasih telah bertransaksi, selesaikan pembayaran untuk berlangganan."}}')
                        ->post('https://api.sandbox.midtrans.com/v1/payment-links');
                    Transaction::create([
                        'customer_id' => $results[$data1['onuinterface']]['id'],
                        'status_code' => 201,
                        'transaction_id' => '',
                        'order_id' => $orderId,
                        'gross_amount' => $paket->price,
                        'payment_type' => '',
                        'transaction_code' => '',
                        'paymentlink' => $paymentLinkId,
                    ]);
                    Customer::where('id', $results[$data1['onuinterface']]['id'])->update([
                        'expire' => null,
                    ]);
                }
            }
        }
    }
}
