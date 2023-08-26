<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Customer;
use App\Models\Odp;
use App\Models\Olt;
use App\Models\Paket;
use App\Models\Telnet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $title = 'Pelanggan | Jenius';
        $activeLink = 'dashboard';
        $customersCalc = Customer::all();

        $clientExp = $customersCalc->filter(function ($customer) {
            return empty($customer->expire);
        })->count();

        return view('admin.customers.index', compact('title', 'activeLink', 'customersCalc', 'clientExp'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $title = 'Pelanggan | Jenius';
        $activeLink = 'dashboard';
        $paket = Paket::all();
        $odp = Odp::all();
        $dataOlt = [];
        $availablePort = '';
        $sn = $request->get('getSn');
        $onuindex = $request->get('onuIndex');
        $parts = explode("_", $onuindex); // Memisahkan string berdasarkan tanda "_"
        $index = explode(":", $parts[1]);

        $telnet = new Telnet();
        $getactiveolt = Olt::where('status', 1)->first();
        if ($getactiveolt != null) {
            $result = $telnet->Connect($getactiveolt->host, $getactiveolt->user, $getactiveolt->password, $getactiveolt->port);
            if ($result == 0) {
                // cek ketersediaan port
                $output = $telnet->runCommand('show gpon onu state');
                $telnet->Disconnect();
                $dataOlt = $processedData = Telnet::processOutput($output);
                $availablePort = Telnet::setOltPort($dataOlt, $index[0]);
            }
        }
        return view('admin.customers.create', compact('title', 'activeLink', 'paket', 'dataOlt', 'availablePort', 'sn', 'odp'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestValidate = $request->validate([
            'onu' => 'required|unique:customers',
            'sn' => 'required',
            'odp_id' => 'required',
            'nik' => 'required|integer|unique:customers',
            'foto_ktp' => 'required|mimes:jpg,jpeg,png|max:512|file',
            'name' => 'required',
            'type' => 'required',
            'paket_id' => 'required',
            'email' => 'required|email:dns',
            'hp' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required',
            'password' => 'required',
        ]);


        $requestValidate['foto_ktp'] = $request->file('foto_ktp')->store('ktp');
        $customerid = rand(1, 9999999999);
        $paymentLinkId =  preg_replace("/[^a-zA-Z0-9]/", '', base64_encode($request->email . $request->hp . rand(10, 9999999999)));
        $orderId = rand(1000, 1000000000000);
        $getactiveolt = Olt::where('status', 1)->first();

        $requestValidate['id'] = $customerid;
        $requestValidate['olt_id'] = $getactiveolt->id;

        $paket = Paket::where('id', $request->paket_id)->first();
        $telnet = new Telnet();
        if ($getactiveolt != null) {
            $result = $telnet->Connect($getactiveolt->host, $getactiveolt->user, $getactiveolt->password, $getactiveolt->port);
            if ($result == 0) {

                $parts = explode(":", $request->onu); // Memisahkan string berdasarkan tanda ":" menjadi array
                $lastPart = end($parts); // Mengambil elemen terakhir dari array

                $interface = $request->onu;
                $modifiedinterface = substr($interface, 0, strpos($interface, ":"));
                $oltName = str_replace(" ", "", strtolower($request->name));

                $addCommand = 'config t
interface gpon-olt_' . $modifiedinterface  . '
onu ' . $lastPart  . ' type ' . $request->type  . ' sn ' . $request->sn  . '
!
interface gpon-onu_' . $request->onu  . '
name ' . $oltName  . '
description $' . $oltName  . '$
sn-bind enable sn
tcont 1 name Internet profile ' . $paket->speed  . 'MB
gemport 1 traffic-limit upstream DOWN-' . $paket->speed  . 'MB downstream DOWN-' . $paket->speed  . 'MB
service-port 1 vport 1 user-vlan ' . $request->vlan  . ' vlan ' . $request->vlan  . '
service-port 1 description ' . $request->vlan  . '
!
pon-onu-mng gpon-onu_' . $request->onu  . '
service Internet gemport 1 vlan ' . $request->vlan  . '
wan-ip 1 mode pppoe username @' . $oltName  . ' password ' . $request->password . ' vlan-profile ' . $request->vlanprofile  . ' host 1
wan-ip 1 ping-response enable traceroute-response enable
interface wifi wifi_0/1 state unlock
ssid ctrl wifi_0/1 name HOME-WIFI-1
ssid auth wpa wifi_0/1 wpa2-psk encrypt aes key ' . $request->password  . '
wan 1 ethuni 1 ssid 1 service internet host 1
!';
                $telnet->runCommand($addCommand);

                $telnet->Disconnect();
            }

            $biayaAdmin = DB::table('transactionsettings')->first();
            $totalBiaya = $paket->price + $biayaAdmin->biaya_admin ?? 0;
            $response = Http::withBasicAuth("SB-Mid-server-m9r2dUIe58EggFEyTflF8orC:", "")
                ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
                ->withBody('
                {"transaction_details":{"order_id":"' . $orderId . '","gross_amount":' . $totalBiaya . ',"payment_link_id":"' . $paymentLinkId . '"},"credit_card":{"secure":true},"usage_limit":999,"expiry":{"duration":1,"unit":"days"},"item_details":[{"id":' . $paket->id . ',"name": "' . $paket->speed . 'mbps","price":' . $totalBiaya . ',"quantity":1}],"customer_details":{"first_name":"' . $request->name . '","last_name":"","email":"' . $request->email . '","phone":"' . $request->hp . '","notes":"Terimakasih telah bertransaksi, selesaikan pembayaran untuk berlangganan."}}')
                ->post('https://api.sandbox.midtrans.com/v1/payment-links');


            // $statusCode = $response->getStatusCode();
            // $result = json_decode($response->getBody()->getContents(), true);

            // return response()->json([
            //     'status_code' => $statusCode,
            //     'result' => $result
            // ]);

            Customer::create($requestValidate);
            Transaction::create([
                'olt_id' => $getactiveolt->id,
                'customer_id' => $customerid,
                'status_code' => 201,
                'transaction_id' => '',
                'order_id' => $orderId,
                'gross_amount' => ($paket->price + $biayaAdmin->biaya_admin),
                'payment_type' => '',
                'transaction_code' => '',
                'paymentlink' => $paymentLinkId,
            ]);


            $data_email = [
                'subject' => 'no-reply | Selesaikan Pembayaran Anda',
                'type' => 'payment',
                'name' => $request->name,
                'paket' => $paket->speed,
                'price' => $paket->price,
                'biayaAdmin' => $biayaAdmin->biaya_admin,
                'linkPayment' => "https://app.sandbox.midtrans.com/payment-links/" . $paymentLinkId,
                'link' => env('APP_URL') . '/verify/' . $request->email,
            ];

            Mail::to($request->email)->send(new SendEmail($data_email));
            return redirect('/admin/customers')->with('success', 'Berhasil mendaftarkan pelanggan');
        }
        return redirect('/admin/customers/create')->with('error', 'Tidak ada koneksi ke OLT');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $title = 'Pelanggan | Jenius';
        $activeLink = 'dashboard';
        $customers = Customer::with('transactions')->where('id', $customer->id)->get();
        $customer = DB::table('customers')
            ->rightJoin('paket', 'paket.id', '=', 'customers.paket_id')
            ->where('paket.id', $customer->paket_id)
            ->first();
        return view('admin.customers.detailCustomer', compact('title', 'activeLink', 'customers', 'customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function map()
    {
        $title = 'Pelanggan | Jenius';
        $activeLink = 'dashboard';

        $olt = Olt::where('status', 1)->first();
        $customers = Customer::with('odp')->where('olt_id', $olt->id ?? 0)->get();

        $customers = json_encode($customers);
        return view('admin.customers.map', compact('title', 'activeLink', 'customers'));
    }
}
