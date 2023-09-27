<?php

namespace App\Http\Controllers;

use App\Models\Odc;
use App\Models\Odp;
use App\Models\Olt;
use App\Models\Telnet;
use App\Models\TelnetSingleton;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class OltController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Olt | Jenius';
        $activeLink = 'dashboard';

        $responseOlt = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get('http://127.0.0.1:8080/api/gettelnet');

        $olt = json_decode($responseOlt->getBody()->getContents(), true);

        $responseConnect = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get('http://127.0.0.1:8080/api/olt/getconnect');

        $oltActive = json_decode($responseConnect->getBody()->getContents(), true);


        return view('admin.olt.index', compact('title', 'activeLink', 'olt', 'oltActive'));
    }

    public function disconnect()
    {
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get('http://127.0.0.1:8080/api/olt/disconnect');

        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            return redirect('/admin/olt')->with('success', 'Berhasil terputus');
        }
        return redirect('/admin/olt')->with('error', 'Gagal memutuskan hubungan');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestValidate = $request->validate([
            'host' => 'required',
            'username' => 'required',
            'port' => 'required|integer',
            'password' => 'required',
        ]);

        $data = json_encode($requestValidate);

        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->withBody($data)
            ->post('http://127.0.0.1:8080/api/telnet');

        if (isset($response['message'])) {
            return redirect('/admin/olt')->with('success', $response['message']);
        }
        return redirect('/admin/olt')->with('error', $response['failed']);
        // // Olt::create($requestValidate);
        // return redirect('/admin/olt')->with('success', 'Berhasil menambahkan olt baru');
    }

    /**
     * Display the specified resource.
     */
    public function show($olt)
    {
        $title = 'Olt | Jenius';
        $activeLink = 'dashboard';
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get('http://127.0.0.1:8080/api/telnet/' . $olt);

        $olt = json_decode($response->getBody()->getContents(), true);
        $odc = Odc::with('odp')->where('olt_id', $olt)->get();

        return view('admin.olt.show', compact('title', 'activeLink', 'olt', 'odc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = 'Olt | Jenius';
        $activeLink = 'dashboard';
        $responseOlt = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get('http://127.0.0.1:8080/api/telnet/' . $id);

        $olt = json_decode($responseOlt->getBody()->getContents(), true);
        return view('admin.olt.edit', compact('title', 'activeLink', 'olt'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $requestValidate = $request->validate([
            'host' => 'required',
            'username' => 'required',
            'port' => 'required|integer',
        ]);
        $requestValidate['password'] = $request->password == null ? "" : $request->password;

        $data = json_encode($requestValidate);
        // dd($data);
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->withBody($data)
            ->put('http://127.0.0.1:8080/api/telnet/' . $id);

        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            return redirect('/admin/olt')->with('success', $response['message']);
        }
        return redirect('/admin/olt')->with('error', $response['message']);
    }

    public function setActive($id)
    {
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->post('http://127.0.0.1:8080/api/olt/connect/' . $id);

        if (isset($response['message'])) {
            return redirect('/admin/olt')->with('success', $response['message']);
        }
        return redirect('/admin/olt')->with('error', $response['failed']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->delete('http://127.0.0.1:8080/api/telnet/' . $id);

        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            return redirect('/admin/olt')->with('success', $response['message']);
        }
        return redirect('/admin/olt')->with('error', $response['failed']);
    }

    public function listonu()
    {
        $title = 'Daftar Onu | Jenius';
        $activeLink = 'dashboard';

        return view('admin.olt.listOnu', compact('title', 'activeLink'));
    }

    public function reboot()
    {
        $rebootCommand = 'conf t
pon-onu-mng' . $_GET['onu'] . '
reboot
';
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->withBody(json_encode(['command' => $rebootCommand], JSON_UNESCAPED_SLASHES))
            ->post(env('OLT_API_URL') . 'api/olt/command/create');

        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            return redirect('/admin')->with('success', 'Berhasil melakukan reboot');
        }
        return redirect('/admin')->with('error', 'Gagal melakukan reboot');
    }
}
