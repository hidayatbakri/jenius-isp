<?php

namespace App\Http\Controllers;

use App\Models\Odc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class OdcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

        Odc::create($requestValidate);

        return redirect()->back()->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Odc $odc)
    {
        $title = 'Alat | Jenius';
        $activeLink = 'dashboard';
        $tool = Odc::with('odp')->where('id', $odc->id)->first();
        return view('admin.tools.show', compact('title', 'activeLink', 'tool'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Odc $odc)
    {
        $title = 'Alat | Jenius';
        $activeLink = 'dashboard';
        $type = 'odc';
        $response = Http::withToken("9309aa9699e17138af7081fb07d0d9fa:")
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get(env('OLT_API_URL') . 'api/gettelnet');
        $olt = json_decode($response->getBody()->getContents(), true);
        // $dc = Odc::with('odp')->get();
        return view('admin.tools.edit', compact('title', 'activeLink', 'type', 'odc', 'olt'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Odc $odc)
    {
        $requestValidate = $request->validate([
            'olt_id' => 'required',
            'name' => 'required',
            'head' => 'required',
            'address' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($request->foto != null) {
            Storage::disk()->delete($odc->foto);
            $requestValidate['foto'] = $request->file('foto')->store('alat');
        }

        Odc::where('id', $odc->id)->update($requestValidate);

        return redirect('/admin/tools')->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Odc $odc)
    {
        Odc::where('id', $odc->id)->delete();
        Storage::disk()->delete($odc->foto);
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
