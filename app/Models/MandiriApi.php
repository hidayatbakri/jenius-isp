<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MandiriApi extends Model
{
    use HasFactory;
    public $timestamp;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function signature()
    {
        $timestamp = Carbon::now()->toIso8601String();
        $privateKeyPath = storage_path('app\API_Portal.pem');
        $password = 'a123';
        $data = env("CLIENT_ID_MANDIRI") . '|' . $timestamp;
        $rsaAlgorithm = OPENSSL_ALGO_SHA256;

        // Load private key file
        $fp = fopen($privateKeyPath, 'r');
        $privatekey_file = fread($fp, 8192);
        fclose($fp);
        $privateKey = openssl_pkey_get_private($privatekey_file, $password);

        // Sign data
        openssl_sign($data, $signature, $privateKey, $rsaAlgorithm);
        $setSignature = base64_encode($signature) . PHP_EOL;
        return $setSignature;
    }

    public function auth()
    {

        $timestamp = Carbon::now()->toIso8601String();
        $privateKeyPath = storage_path('app\API_Portal.pem');
        $password = 'a123';
        $data = env("CLIENT_ID_MANDIRI") . '|' . $timestamp;
        $rsaAlgorithm = OPENSSL_ALGO_SHA256;

        // Load private key file
        $fp = fopen($privateKeyPath, 'r');
        $privatekey_file = fread($fp, 8192);
        fclose($fp);
        $privateKey = openssl_pkey_get_private($privatekey_file, $password);

        // Sign data
        openssl_sign($data, $signature, $privateKey, $rsaAlgorithm);
        // dd(base64_encode($signature) . PHP_EOL);
        $setSignature = base64_encode($signature) . PHP_EOL;

        $timestamp = Carbon::now()->toIso8601String();
        $endpoint = 'https://sandbox.bankmandiri.co.id/openapi/auth/v2.0/access-token/b2b';
        $data = [
            'grantType' => 'client_credentials',
        ];
        $signt = base64_encode($setSignature);
        $headers = [
            'X-CLIENT-KeY' =>  env("CLIENT_ID_MANDIRI"),
            'X-TIMESTAMP' => $timestamp,
            'X-SIGNATURE' => $signt
        ];

        $response = Http::withHeaders($headers)->post($endpoint, $data);

        if ($response->failed()) {
            return 'Error: ' . $response->body();
        }

        return $response->body();
    }
}
