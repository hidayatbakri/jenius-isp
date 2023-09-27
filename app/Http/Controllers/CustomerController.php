<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\Odp;
use App\Models\Olt;
use App\Models\Paket;
use App\Models\TelegramApi;
use App\Models\Telnet;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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

        if (Auth::user()->email_verified_at == null) {
            Auth::logout();
            return view('auth.login');
        }

        $clientExp = $customersCalc->filter(function ($customer) {
            return empty($customer->expire);
        })->count();

        return view('admin.customers.index', compact('title', 'activeLink', 'customersCalc', 'clientExp'));
    }

    public function configure(Request $request)
    {
        $title = 'Konfigurasi Pelanggan | Jenius';
        $activeLink = 'dashboard';
        $paket = Paket::all();
        $odp = Odp::all();
        $requestValidate = $request->validate([
            'onu' => 'required'
        ]);
        $data = json_encode($requestValidate, JSON_UNESCAPED_SLASHES);
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->withBody($data)
            ->post(env('OLT_API_URL') . 'api/olt/profile');
        $profile = json_decode($response->getBody()->getContents(), true);
        return view('admin.customers.configure', compact('title', 'activeLink', 'profile', 'odp', 'paket'));
    }

    public function postConfigure(Request $request)
    {
        $requestValidate = $request->validate([
            'odp_id' => 'required',
            'nik' => 'required|integer|unique:customers',
            'foto_ktp' => 'required|mimes:jpg,jpeg,png|max:512|file',
            'foto_rumah' => 'required|mimes:jpg,jpeg,png|max:512|file',
            'status_rumah' => 'required',
            'paket_id' => 'required',
            'email' => 'required|email:dns',
            'hp' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required',
        ]);

        $dataonu = ["onu" => $request->onuinterface];
        $data = json_encode($dataonu, JSON_UNESCAPED_SLASHES);
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->withBody($data)
            ->post(env('OLT_API_URL') . 'api/olt/profile');
        $profile = json_decode($response->getBody()->getContents(), true);
        $requestValidate["name"] = $profile['name'];
        $requestValidate["olt_id"] = $profile['id_telnet'];
        $requestValidate["onu"] = $profile['onuinterface'];
        $requestValidate["type"] = $profile['type'];

        $requestValidate['foto_ktp'] = $request->file('foto_ktp')->store('ktp');
        $requestValidate['foto_rumah'] = $request->file('foto_rumah')->store('rumah');
        $customerid = rand(1, 9999999999);
        $requestValidate["id"] = $customerid;
        $paymentLinkId =  preg_replace("/[^a-zA-Z0-9]/", '', base64_encode($request->email . $request->hp . rand(10, 9999999999)));
        $orderId = rand(1000, 1000000000000);
        $paket = Paket::where('id', $request->paket_id)->first();
        $biayaAdmin = DB::table('transactionsettings')->first();
        $totalBiaya = $paket->price + $biayaAdmin->biaya_admin ?? 0;
        $response = Http::withBasicAuth("SB-Mid-server-m9r2dUIe58EggFEyTflF8orC:", "")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->withBody('
                {"transaction_details":{"order_id":"' . $orderId . '","gross_amount":' . $totalBiaya . ',"payment_link_id":"' . $paymentLinkId . '"},"credit_card":{"secure":true},"usage_limit":999,"expiry":{"duration":1,"unit":"days"},"item_details":[{"id":' . $paket->id . ',"name": "' . $paket->speed . 'mbps","price":' . $totalBiaya . ',"quantity":1}],"customer_details":{"first_name":"' . $profile['name'] . '","last_name":" ","email":"' . $request->email . '","phone":"' . $request->hp . '","notes":"Terimakasih telah bertransaksi, selesaikan pembayaran untuk berlangganan."}}')
            ->post('https://api.sandbox.midtrans.com/v1/payment-links');
        Customer::create($requestValidate);
        Transaction::create([
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
            'name' => $requestValidate["name"],
            'paket' => $paket->speed,
            'price' => $paket->price,
            'biayaAdmin' => $biayaAdmin->biaya_admin,
            'linkPayment' => "https://app.sandbox.midtrans.com/payment-links/" . $paymentLinkId,
            'link' => env('APP_URL') . '/verify/' . $request->email,
        ];

        Mail::to($request->email)->send(new SendEmail($data_email));
        return redirect('/admin/customers')->with('success', 'Berhasil konfigurasi pelanggan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $title = 'Pelanggan | Jenius';
        $activeLink = 'dashboard';
        $paket = Paket::all();
        $odp = Odp::with('odc')->get();
        $sn = $request->get('getSn');
        $onuindex = $request->get('onuIndex');

        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->withBody(json_encode(['onu' => $onuindex], JSON_UNESCAPED_SLASHES))
            ->post(env('OLT_API_URL') . 'api/olt/availableport');
        $availablePort = json_decode($response->getBody()->getContents(), true);
        $availablePort = isset($availablePort['message']) ? '' : $availablePort['data'];

        return view('admin.customers.create', compact('title', 'activeLink', 'paket', 'availablePort', 'sn', 'odp'));
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
            'foto_rumah' => 'required|mimes:jpg,jpeg,png|max:512|file',
            'status_rumah' => 'required',
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

        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get(env('OLT_API_URL') . 'api/olt/getconnect');
        $olt = json_decode($response->getBody()->getContents(), true);
        $requestValidate["olt_id"] = $olt['id'];
        $requestValidate['foto_ktp'] = $request->file('foto_ktp')->store('ktp');
        $requestValidate['foto_rumah'] = $request->file('foto_rumah')->store('rumah');
        $customerid = rand(1, 9999999999);
        $requestValidate["id"] = $customerid;
        $paymentLinkId =  preg_replace("/[^a-zA-Z0-9]/", '', base64_encode($request->email . $request->hp . rand(10, 90999999999)));
        $orderId = rand(1000, 1000000000000);
        $paket = Paket::where('id', $request->paket_id)->first();
        $biayaAdmin = DB::table('transactionsettings')->first();
        $totalBiaya = $paket->price + $biayaAdmin->biaya_admin ?? 0;
        $parts = explode(":", $request->onu); // Memisahkan string berdasarkan tanda ":" menjadi array
        $lastPart = end($parts);
        $interface = $request->onu;
        $modifiedinterface = substr($interface, 0, strpos($interface, ":"));
        $oltName = str_replace(" ", "", strtolower($request->name));
        $addCommand = "config t
interface gpon-olt_" . $modifiedinterface  . "
onu " . $lastPart  . " type " . $request->type  . " sn " . $request->sn  . "
!
interface gpon-onu_" . $request->onu  . "
name " . $oltName  . "
description $" . $oltName  . "$
sn-bind enable sn
tcont 1 name Internet profile " . $paket->speed  . "MB
gemport 1 traffic-limit upstream DOWN-" . $paket->speed  . "MB downstream DOWN-" . $paket->speed  . "MB
service-port 1 vport 1 user-vlan " . $request->vlan  . " vlan " . $request->vlan  . "
service-port 1 description " . $request->vlan  . "
!
pon-onu-mng gpon-onu_" . $request->onu  . "
service Internet gemport 1 vlan " . $request->vlan  . "
wan-ip 1 mode pppoe username @" . $oltName  . " password " . $request->password . " vlan-profile " . $request->vlanprofile  . " host 1
wan-ip 1 ping-response enable traceroute-response enable
interface wifi wifi_0/1 state unlock
ssid ctrl wifi_0/1 name HOME-WIFI-1
ssid auth wpa wifi_0/1 wpa2-psk encrypt aes key " . $request->password  . "
wan 1 ethuni 1 ssid 1 service internet host 1
!
";
        $execCommand = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->withBody(json_encode(['command' => $addCommand], JSON_UNESCAPED_SLASHES))
            ->post(env('OLT_API_URL') . 'api/olt/command/create');
        $response = Http::withBasicAuth("SB-Mid-server-m9r2dUIe58EggFEyTflF8orC:", "")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->withBody('
            {"transaction_details":{"order_id":"' . $orderId . '","gross_amount":' . $totalBiaya . ',"payment_link_id":"' . $paymentLinkId . '"},"credit_card":{"secure":true},"usage_limit":999,"expiry":{"duration":1,"unit":"days"},"item_details":[{"id":' . $paket->id . ',"name": "' . $paket->speed . 'mbps","price":' . $totalBiaya . ',"quantity":1}],"customer_details":{"first_name":"' . $request->name . '","last_name":" ","email":"' . $request->email . '","phone":"' . $request->hp . '","notes":"Terimakasih telah bertransaksi, selesaikan pembayaran untuk berlangganan."}}')
            ->post('https://api.sandbox.midtrans.com/v1/payment-links');

        $requestValidate['onu'] = 'gpon-onu_' . $request->onu;
        Customer::create($requestValidate);
        Transaction::create([
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
            'name' => $requestValidate["name"],
            'paket' => $paket->speed,
            'price' => $paket->price,
            'biayaAdmin' => $biayaAdmin->biaya_admin,
            'linkPayment' => "https://app.sandbox.midtrans.com/payment-links/" . $paymentLinkId,
            'link' => env('APP_URL') . '/verify/' . $request->email,
        ];
        Mail::to($request->email)->send(new SendEmail($data_email));

        $cp = new CustomerProfile();
        $cp->refresh();

        return redirect('/admin/customers')->with('success', 'Berhasil menambah user');
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
            ->where([['paket.id', $customer->paket_id], ['customers.id', $customer->id]])
            ->first();
        $data = json_encode(["onu" => $customer->onu], JSON_UNESCAPED_SLASHES);
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->withBody($data)
            ->post(env('OLT_API_URL') . 'api/olt/profile');
        $profile = json_decode($response->getBody()->getContents(), true);
        $odp = Odp::where('id', $customer->odp_id)->first();
        return view('admin.customers.detailCustomer', compact('title', 'activeLink', 'customers', 'customer', 'odp', 'profile'));
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
    public function destroy($id, Request $request)
    {
        $customer = Customer::where('id', $id)->first();

        $inputString = $customer != null ? $customer->onu : $request->onu;
        $parts = explode("_", $inputString);
        $onu = explode(":", $parts[1])[0];
        $index = explode(":", $parts[1])[1];
        $deleteCommand = "conf t
interface gpon-olt_" . $onu . "
no onu " . $index . "
";

        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->withBody(json_encode(['command' => $deleteCommand], JSON_UNESCAPED_SLASHES))
            ->post(env('OLT_API_URL') . 'api/olt/command/delete');
        // dd(json_decode($response->getBody()->getContents(), true));

        $cp = new CustomerProfile();
        $cp->refresh();

        Storage::disk()->delete($customer->foto_ktp);
        Storage::disk()->delete($customer->foto_rumah);
        Customer::find($customer->id)->delete();
        // Transaction::where('customer_id', $customer->id)->delete();
        return redirect('/admin/customers');
    }

    public function refresh()
    {
        $cp = new CustomerProfile();
        $cp->refresh();

        return redirect('/admin/customers');
    }

    public function map()
    {
        $title = 'Pelanggan | Jenius';
        $activeLink = 'dashboard';

        $olt = Olt::where('status', 1)->first();
        $customers = Customer::with('odp')->where('olt_id', $olt->id ?? 0)->get();

        $customers = json_encode($customers);
        return view('admin.customers.map', compact('title', 'activeLink', 'customers'));
        return redirect('/admin/customers')->with('success', 'Berhasil menghapus user');
    }
}
