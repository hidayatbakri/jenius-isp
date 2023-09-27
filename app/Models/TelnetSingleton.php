<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelnetSingleton extends Model
{
    use HasFactory;

    private static $instance = null;
    private $telnet = null;

    private function __construct()
    {
        // Private constructor to prevent external instantiation
        $this->initTelnetConnection();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function initTelnetConnection()
    {
        $getactiveolt = Olt::where('status', 1)->first();

        if ($getactiveolt) {
            $this->telnet = new Telnet();
            $result = $this->telnet->Connect($getactiveolt->host, $getactiveolt->user, $getactiveolt->password, $getactiveolt->port);

            if ($result !== 0) {
                $this->telnet = null; // Connection failed, set telnet to null
            }
        }
    }

    public function getTelnet()
    {
        return $this->telnet;
    }
}
