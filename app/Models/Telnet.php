<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\Dump;

class Telnet extends Model
{
    use HasFactory;

    var $show_connect_error = 1;

    var $use_usleep = 0;    // change to 1 for faster execution
    // don't change to 1 on Windows servers unless you have PHP 5
    var $sleeptime = 125000;
    var $loginsleeptime = 1000000;

    var $fp = NULL;
    var $loginprompt;

    var $conn1;
    var $conn2;

    /*
	0 = success
	1 = couldn't open network connection
	2 = unknown host
	3 = login failed
	4 = PHP version too low
	*/
    public function Connect($server, $user, $pass, $port)
    {
        $rv = 0;
        $vers = explode('.', PHP_VERSION);
        $needvers = array(4, 3, 0);
        $j = count($vers);
        $k = count($needvers);
        if ($k < $j) $j = $k;
        for ($i = 0; $i < $j; $i++) {
            if (($vers[$i] + 0) > $needvers[$i]) break;
            if (($vers[$i] + 0) < $needvers[$i]) {
                $this->ConnectError(4);
                return 4;
            }
        }

        $this->Disconnect();

        if (strlen($server)) {
            if (preg_match('/[^0-9.]/', $server)) {
                $ip = gethostbyname($server);
                if ($ip == $server) {
                    $ip = '';
                    $rv = 2;
                }
            } else $ip = $server;
        } else $ip = '127.0.0.1';

        if (strlen($ip)) {
            if ($this->fp = fsockopen($ip, $port)) {
                fputs($this->fp, $this->conn1);
                $this->Sleep();

                fputs($this->fp, $this->conn2);
                $this->Sleep();
                $this->GetResponse($r);
                $r = explode("\n", $r);
                $this->loginprompt = $r[count($r) - 1];

                fputs($this->fp, "$user\r");
                $this->Sleep();

                fputs($this->fp, "$pass\r");
                if ($this->use_usleep) usleep($this->loginsleeptime);
                else sleep(1);
                $this->GetResponse($r);
                $r = explode("\n", $r);
                if (($r[count($r) - 1] == '') || ($this->loginprompt == $r[count($r) - 1])) {
                    $rv = 3;
                    $this->Disconnect();
                }
            } else $rv = 1;
        }

        if ($rv) $this->ConnectError($rv);
        return $rv;
    }

    public function Disconnect($exit = 1)
    {
        if ($this->fp) {
            if ($exit) $this->DoCommand('exit', $junk);
            fclose($this->fp);
            $this->fp = NULL;
        }
    }

    public function DoCommand($c, &$r)
    {
        if ($this->fp) {
            fputs($this->fp, "$c\r");
            $this->Sleep();
            $this->GetResponse($r);
            $r = preg_replace("/^.*?\n(.*)\n[^\n]*$/", "$1", $r);
        }
        return $this->fp ? 1 : 0;
    }

    public function GetResponse(&$r)
    {
        $r = '';
        do {
            $r .= fread($this->fp, 1000);
            $s = socket_get_status($this->fp);
        } while ($s['unread_bytes']);
    }

    public function Sleep()
    {
        if ($this->use_usleep) usleep($this->sleeptime);
        else sleep(1);
    }

    public function PHPTelnet()
    {
        $this->conn1 = chr(0xFF) . chr(0xFB) . chr(0x1F) . chr(0xFF) . chr(0xFB) .
            chr(0x20) . chr(0xFF) . chr(0xFB) . chr(0x18) . chr(0xFF) . chr(0xFB) .
            chr(0x27) . chr(0xFF) . chr(0xFD) . chr(0x01) . chr(0xFF) . chr(0xFB) .
            chr(0x03) . chr(0xFF) . chr(0xFD) . chr(0x03) . chr(0xFF) . chr(0xFC) .
            chr(0x23) . chr(0xFF) . chr(0xFC) . chr(0x24) . chr(0xFF) . chr(0xFA) .
            chr(0x1F) . chr(0x00) . chr(0x50) . chr(0x00) . chr(0x18) . chr(0xFF) .
            chr(0xF0) . chr(0xFF) . chr(0xFA) . chr(0x20) . chr(0x00) . chr(0x33) .
            chr(0x38) . chr(0x34) . chr(0x30) . chr(0x30) . chr(0x2C) . chr(0x33) .
            chr(0x38) . chr(0x34) . chr(0x30) . chr(0x30) . chr(0xFF) . chr(0xF0) .
            chr(0xFF) . chr(0xFA) . chr(0x27) . chr(0x00) . chr(0xFF) . chr(0xF0) .
            chr(0xFF) . chr(0xFA) . chr(0x18) . chr(0x00) . chr(0x58) . chr(0x54) .
            chr(0x45) . chr(0x52) . chr(0x4D) . chr(0xFF) . chr(0xF0);
        $this->conn2 = chr(0xFF) . chr(0xFC) . chr(0x01) . chr(0xFF) . chr(0xFC) .
            chr(0x22) . chr(0xFF) . chr(0xFE) . chr(0x05) . chr(0xFF) . chr(0xFC) . chr(0x21);
    }

    public function ConnectError($num)
    {
        if ($this->show_connect_error) switch ($num) {
            case 1:
                echo '<br />[PHP Telnet] <a href="http://www.geckotribe.com/php-telnet/errors/fsockopen.php">Connect failed: Unable to open network connection</a><br />';
                break;
            case 2:
                echo '<br />[PHP Telnet] <a href="http://www.geckotribe.com/php-telnet/errors/unknown-host.php">Connect failed: Unknown host</a><br />';
                break;
            case 3:
                echo '<br />[PHP Telnet] <a href="http://www.geckotribe.com/php-telnet/errors/login.php">Connect failed: Login failed</a><br />';
                break;
            case 4:
                echo '<br />[PHP Telnet] <a href="http://www.geckotribe.com/php-telnet/errors/php-version.php">Connect failed: Your server\'s PHP version is too low for PHP Telnet</a><br />';
                break;
        }
    }

    public function runCommand($command)
    {
        // $this->Connect('your_server_ip', 'your_username', 'your_password');
        $output = '';
        $this->DoCommand($command, $output);
        // $this->Disconnect();

        return $output;
    }

    // public function parseOutput($output)
    // {
    //     $lines = explode("\n", $output);
    //     $data = [];
    //     $headers = [];
    //     $separator = str_repeat('-', strlen(trim($lines[1])));

    //     // Process headers
    //     $headerLine = trim($lines[0]);
    //     $headerValues = preg_split('/\s+/', $headerLine);
    //     foreach ($headerValues as $headerValue) {
    //         $headers[] = $headerValue;
    //     }

    //     // Process data rows
    //     foreach ($lines as $line) {
    //         $line = trim($line);
    //         if ($line !== $separator && $line !== $headerLine && !empty($line)) {
    //             $values = preg_split('/\s+/', $line);
    //             $row = [];
    //             for ($i = 0; $i < count($headers); $i++) {
    //                 $row[$headers[$i]] = $values[$i];
    //             }
    //             $data[] = $row;
    //         }
    //     }

    //     return $data;
    // }

    public static function processOutput($output)
    {
        $lines = explode("\r\n", $output);
        $data = [];
        $headers = [];
        if (count($lines) < 2) {
            return $lines;
            exit;
        } else {

            $separator = str_repeat('-', strlen(trim($lines[1])));
            $headerLine = trim($lines[1]);
            $headerValues = explode(' ', preg_replace('/\s+/', ' ', $headerLine));

            // Process headers
            foreach ($headerValues as $headerValue) {
                $headers[] = strtolower($headerValue);
            }


            // Process data rows
            for ($i = 2; $i < count($lines); $i++) {
                $values = preg_split('/\s+/', $lines[$i]);
                $row = [];
                $rowval = [];
                $values = array_values($values);
                for ($j = 0; $j < count($headers); $j++) {
                    foreach ($values as $val) {
                        $rowval[] = $val;
                        $row[$headers[$j]] = $rowval[$j];
                    }
                }
                $data[] = $row;
            }
            // die;
            unset($data[0]);
            unset($data[count($data)]);
            $data = array_values($data);
            // dd($data);
            return $data;
        }
    }

    public function getPowerFromArrayOfData($dataArray)
    {
        $result = [];
        foreach ($dataArray as $data) {
            $commandResult = $this->runCommand("show pon power attenuation " . $data['onuinterface']);
            $powerData = $this->parsePowerData($commandResult);
            $result[$data['onuinterface']] = $powerData;
        }
        return $result;
    }

    public function parsePowerData($data)
    {
        $lines = explode("\n", $data);

        $powerData = [];

        foreach ($lines as $line) {
            if (preg_match('/down\s+Tx :([0-9.-]+)\(dbm\)\s+Rx:([0-9.-]+)\(dbm\)\s+([0-9.-]+)\(dB\)/', $line, $matches)) {
                $powerData[] = [
                    'direction' => 'down',
                    'rx' => $matches[2],
                    'tx' => $matches[1],
                    'attenuation' => $matches[3]
                ];
            }
        }

        return $powerData;
    }
    // if (preg_match('/up\s+Rx :([0-9.-]+)\(dbm\)\s+Tx:([0-9.-]+)\(dbm\)\s+([0-9.-]+)\(dB\)/', $line, $matches)) {
    //     $powerData[] = [
    //         'direction' => 'up',
    //         'rx' => $matches[1],
    //         'tx' => $matches[2],
    //         'attenuation' => $matches[3]
    //     ];
    // } else


    public static function getPower($data)
    {
        // Memisahkan blok data berdasarkan baris kosong
        $lines = explode("\n", $data);

        $allData = [];

        foreach ($lines as $line) {
            // Memisahkan nilai-nilai menggunakan regex
            if (preg_match('/up\s+Rx :([0-9.-]+)\(dbm\)\s+Tx:([0-9.-]+)\(dbm\)\s+([0-9.-]+)\(dB\)/', $line, $matches)) {
                $result[] = [
                    'direction' => 'up',
                    'rx' => $matches[1],
                    'tx' => $matches[2],
                    'attenuation' => $matches[3]
                ];
            } elseif (preg_match('/down\s+Tx :([0-9.-]+)\(dbm\)\s+Rx:([0-9.-]+)\(dbm\)\s+([0-9.-]+)\(dB\)/', $line, $matches)) {
                $result[] = [
                    'direction' => 'down',
                    'rx' => $matches[2],
                    'tx' => $matches[1],
                    'attenuation' => $matches[3]
                ];
            }
        }

        dd($result);
    }

    public static function setOltPort($getdata, $index)
    {
        $availablePort = $index . ":1";  // Port default
        unset($getdata[count($getdata) - 1]);
        foreach ($getdata as $item) {
            $onuIndex = $item['onuindex'];

            // Cek apakah onuindex sudah sesuai dengan format "X/X/X:X"
            // Pemeriksaan apakah onuindex sesuai format
            if (preg_match('/^\d+\/\d+\/\d+:\d+$/', $onuIndex)) {
                list($rak, $card, $portData) = explode('/', $onuIndex);
                list($portCard, $portExtend) = explode(':', $portData);
                if ($onuIndex == $availablePort) {
                    // Jika port sudah terisi, geser ke port berikutnya
                    if ($portExtend < 256) {
                        $nextPortExtend = $portExtend + 1;
                        $availablePort = "$rak/$card/$portCard:$nextPortExtend";
                    } elseif ($portCard < 16) {
                        // Geser ke port card berikutnya
                        $nextPortCard = $portCard + 1;
                        $availablePort = "$rak/$card/$nextPortCard:1";
                    } elseif ($card < 18) {
                        // Geser ke card berikutnya
                        $nextCard = $card + 1;
                        $availablePort = "$rak/$nextCard/1:1";
                    } else {
                        // Geser ke rak berikutnya
                        // Anda mungkin perlu menyesuaikan logika ini berdasarkan kebutuhan Anda
                        // Misalnya, jika rak lebih dari 1, Anda mungkin perlu melanjutkan ke rak berikutnya
                        $availablePort = "Rak habis, belum diimplementasikan.";
                    }
                }
            }
        }
        // dd($availablePort);
        return $availablePort;
    }

    public static function processOutputProfile($data)
    {
        $entries = explode('@Rdp#', $data);
        $result = [];

        foreach ($entries as $entry) {
            $lines = explode("\n", trim($entry));
            $entryData = [];

            foreach ($lines as $line) {
                if (preg_match('/^\s*([^:]+):\s*(.*)$/', $line, $matches)) {
                    $key = str_replace(' ', '', strtolower($matches[1]));
                    $value = trim($matches[2]);
                    $entryData[$key] = $value;
                }
            }

            if (!empty($entryData)) {
                $result[] = $entryData;
            }
        }


        return $result;
    }
}
