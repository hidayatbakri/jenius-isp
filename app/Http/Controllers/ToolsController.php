<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Odc;
use App\Models\Odp;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Alat | Jenius';
        $activeLink = 'dashboard';
        $odc = Odc::with('odp')->get();

        // dd($totalOdc);
        $odp = Odp::with('odc')->get();
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get(env('OLT_API_URL') . 'api/gettelnet');
        $olt = json_decode($response->getBody()->getContents(), true);
        return view('admin.tools.index', compact('title', 'activeLink', 'olt',  'odc', 'odp'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestValidate = $request->validate([
            'name' => 'required',
            'head' => 'required',
            'address' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'foto' => 'required|max:516|mimes:jpg,jpeg,png',
        ]);
        $requestValidate['foto'] = $request->file('foto')->store('alat');
        if ($request->type == 1) {
            $requestValidate['olt_id'] = $request->olt_id;
            $requestValidate['port'] = $request->port;
            Odc::create($requestValidate);
        } elseif ($request->type == 0) {
            $requestValidate['odc_id'] = $request->odp;
            Odp::create($requestValidate);
        } else {
            return redirect()->back();
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tool $tool)
    {
        $title = 'Alat | Jenius';
        $activeLink = 'dashboard';
        return view('admin.tools.show', compact('title', 'activeLink', 'tool'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tool $tool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tool $tool)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tool $tool)
    {
    }

    public function map()
    {
        $title = 'Lokasi Alat | Jenius';
        $activeLink = 'dashboard';
        $tools = Odc::with('odp')->get();
        $tools = json_encode($tools);
        $customers = Odp::with('customer')->get();
        // dd($customers);
        $customers = json_encode($customers);
        return view('admin.tools.map', compact('title', 'activeLink', 'tools', 'customers'));
    }
}
