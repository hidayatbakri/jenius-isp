<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Paket;
use App\Models\TelegramApi;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // https://server.smartinovasi.com/api/payment/notif
    }

    public function error(Request $request, $order)
    {
        return $order;
    }

    public function finish(Request $request)
    {
        return view("thanksPay");
    }

    public function mandiriNotif(Request $request)
    {
        return 'oke';
    }

    public function notif(Request $request)
    {
        $data = json_decode($request->getContent());
        $getorder_id = explode("-", $data->order_id);
        $order_id = $getorder_id[0];
        Transaction::where('order_id', $order_id)->update([
            'status_code' => $data->status_code,
            'transaction_id' => $data->transaction_id,
            'payment_type' => $data->payment_type,
            'date' => $data->settlement_time,
        ]);

        $originalDate = $data->settlement_time;
        $carbonDate = Carbon::parse($originalDate);

        $oneMonthLater = $carbonDate->addMonth(); // Tambahkan satu bulan
        $oneMonthLaterFormatted = $oneMonthLater->format('Y-m-d H:i:s');

        $transaction = Transaction::where('order_id', $order_id)->first();
        $customer = Customer::with('paket')->where('id', $transaction->customer_id)->first();
        if ($customer->active == null) {
            Customer::where('id', $transaction->customer_id)->update([
                'active' => $data->settlement_time,
                'expire' => $oneMonthLaterFormatted
            ]);
        } else {
            Customer::where('id', $transaction->customer_id)->update([
                'expire' => $oneMonthLaterFormatted
            ]);
        }
        $telegramApi = new TelegramApi;
        $textReport = "
📢 Informasi Pelanggan 📢
Nama Pelanggan : " . $customer->name . "
Onu : " . $customer->onu . "
Sn : " . $customer->sn . "
Telepon : " . $customer->hp . "
Paket : " . $customer->paket->speed . "
Bayar : Rp. " . number_format($transaction->gross_amount, 0, '.', '.') . "
Status : Dibayar
Lokasi (map) : https://google.com/maps/place/" . $customer->latitude . "," . $customer->longitude . "
        ";
        $telegramApi->sendMessage($textReport);
        $response = Http::withBasicAuth("SB-Mid-server-m9r2dUIe58EggFEyTflF8orC:", "")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->delete('https://api.sandbox.midtrans.com/v1/payment-links/' . $data->order_id);

        return $order_id;
    }

    public function postData(Request $request)
    {
        Transaction::create();
        return json_encode($request);
    }

    public function createPaymentLink(Request $request)
    {

        $response = Http::withBasicAuth("SB-Mid-server-m9r2dUIe58EggFEyTflF8orC:", "")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->withBody('
            {"transaction_details":{"order_id":"1691841573216","gross_amount":190000,"payment_link_id":"1691841573216"},"credit_card":{"secure":true},"usage_limit":5,"expiry":{"duration":30,"unit":"days"},"item_details":[{"id":"tix-001","name":"Exclusive Tour Concert Day 1","price":95000,"quantity":2}],"customer_details":{"first_name":"John","last_name":"Doe","email":"john.doe@example.com","phone":"+62181000000000","notes":"Thank you for your order. Please follow the instructions to complete payment."}}')
            ->post('https://api.sandbox.midtrans.com/v1/payment-links');

        $statusCode = $response->getStatusCode();
        $result = json_decode($response->getBody()->getContents(), true);

        return response()->json([
            'status_code' => $statusCode,
            'result' => $result
        ]);
    }
}
