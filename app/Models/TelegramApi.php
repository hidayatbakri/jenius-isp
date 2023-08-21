<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class TelegramApi extends Model
{
    use HasFactory;
    public $pathApi;

    public function __construct()
    {
        $this->pathApi = "https://api.telegram.org/bot" . env("API_KEY_TELEGRAM") . "/";
    }

    public function sendMessage($message)
    {
        $response = Http::post($this->pathApi . "sendMessage?chat_id=" . env("API_TELEGRAM_CHAT_ID") . "&text=" . $message);

        $statusCode = $response->getStatusCode();
        $result = json_decode($response->getBody()->getContents(), true);
    }
}
