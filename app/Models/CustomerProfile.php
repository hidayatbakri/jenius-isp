<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CustomerProfile extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function refresh()
    {
        $responseOlt = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get(env('OLT_API_URL') . 'api/olt/getconnect');
        $olt = json_decode($responseOlt->getBody()->getContents(), true);
        if ($olt['id'] != null) {
            CustomerProfile::where('olt_id', $olt['id'])->delete();

            $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
                ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
                ->get(env('OLT_API_URL') . 'api/olt/profiles');
            $profiles = json_decode($response->getBody()->getContents(), true);

            if ($profiles != null) {
                foreach ($profiles as $row => $r) {
                    CustomerProfile::insert([
                        'olt_id' => $olt['id'],
                        'onuinterface' => $r['onuinterface'],
                        'name' => $r['name'],
                        'type' => $r['type'],
                        'state' => $r['state'],
                        'configuredchannel' => $r['configuredchannel'],
                        'currentchannel' => $r['currentchannel'],
                        'adminstate' => $r['adminstate'],
                        'phasestate' => $r['phasestate'],
                        'configstate' => $r['configstate'],
                        'authenticationmode' => $r['authenticationmode'],
                        'snbind' => $r['snbind'],
                        'serialnumber' => $r['serialnumber'],
                        'password' => $r['password'],
                        'description' => $r['description'],
                        'vportmode' => $r['vportmode'],
                        'dbamode' => $r['dbamode'],
                        'onustatus' => $r['onustatus'],
                        'omcibwprofile' => $r['omcibwprofile'],
                        'lineprofile' => $r['lineprofile'],
                        'serviceprofile' => $r['serviceprofile'],
                        'onudistance' => $r['onudistance'],
                        'onlineduration' => $r['onlineduration'],
                    ]);
                }
            }
        }
    }
}
