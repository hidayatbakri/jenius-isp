<?php

namespace App\Jobs;

use App\Models\Telnet;
use App\Models\TelnetCache;
use App\Models\TelnetSingleton;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TelnetDataRetrievalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $telnetSingleton = TelnetSingleton::getInstance();
        $telnet = $telnetSingleton->getTelnet();
        $commands = '';


        if ($telnet) {
            $listonu = $telnet->runCommand('show gpon onu state');
            $listonu = Telnet::processOutput($listonu);
            unset($listonu[count($listonu) - 1]);
            foreach ($listonu as $onu) {
                $commands .= 'show gpon onu detail-info gpon-onu_' . $onu['onuindex'] . "\n;";
            }
            $getprofile = $telnet->runCommand($commands);
            $profiles = Telnet::processOutputProfile($getprofile);
            $telnet->Disconnect();

            foreach ($profiles as $row) {
                $cekonu = TelnetCache::where('onuinterface', $row['onuinterface'])->first();
                if ($cekonu) {
                    TelnetCache::where('onuinterface', $row['onuinterface'])->update([
                        'onuinterface' => $row['onuinterface'],
                        'name' => $row['name'],
                        'type' => $row['type'],
                        'state' => $row['state'],
                        'configuredchannel' => $row['configuredchannel'],
                        'currentchannel' => $row['currentchannel'],
                        'adminstate' => $row['adminstate'],
                        'phasestate' => $row['phasestate'],
                        'configstate' => $row['configstate'],
                        'authenticationmode' => $row['authenticationmode'],
                        'snbind' => $row['snbind'],
                        'serialnumber' => $row['serialnumber'],
                        'password' => $row['password'],
                        'description' => $row['description'],
                        'vportmode' => $row['vportmode'],
                        'dbamode' => $row['dbamode'],
                        'onustatus' => $row['onustatus'],
                        'omcibwprofile' => $row['omcibwprofile'],
                        'lineprofile' => $row['lineprofile'],
                        'serviceprofile' => $row['serviceprofile'],
                        'onudistance' => $row['onudistance'],
                        'onlineduration' => $row['onlineduration'],
                    ]);
                } else {
                    TelnetCache::create([
                        'onuinterface' => $row['onuinterface'],
                        'name' => $row['name'],
                        'type' => $row['type'],
                        'state' => $row['state'],
                        'configuredchannel' => $row['configuredchannel'],
                        'currentchannel' => $row['currentchannel'],
                        'adminstate' => $row['adminstate'],
                        'phasestate' => $row['phasestate'],
                        'configstate' => $row['configstate'],
                        'authenticationmode' => $row['authenticationmode'],
                        'snbind' => $row['snbind'],
                        'serialnumber' => $row['serialnumber'],
                        'password' => $row['password'],
                        'description' => $row['description'],
                        'vportmode' => $row['vportmode'],
                        'dbamode' => $row['dbamode'],
                        'onustatus' => $row['onustatus'],
                        'omcibwprofile' => $row['omcibwprofile'],
                        'lineprofile' => $row['lineprofile'],
                        'serviceprofile' => $row['serviceprofile'],
                        'onudistance' => $row['onudistance'],
                        'onlineduration' => $row['onlineduration'],
                    ]);
                }
            }
        }
    }
}
